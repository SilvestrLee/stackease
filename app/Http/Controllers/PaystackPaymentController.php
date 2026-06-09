<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaystackPaymentController extends Controller
{
    public function initialize(Invoice $invoice)
    {
        abort_unless($invoice->user_id === Auth::id(), 403);

        if ($invoice->isPaid()) {
            return back()->with('error', 'This invoice has already been paid.');
        }

        if (! $invoice->isPayable()) {
            return back()->with('error', 'This invoice is not available for online payment.');
        }

        $reference = 'STKE-' . $invoice->id . '-' . strtoupper(Str::random(10));

        $amountInKobo = (int) round(((float) $invoice->total_naira_amount) * 100);

        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                'email' => Auth::user()->email,
                'amount' => $amountInKobo,
                'reference' => $reference,
                'currency' => 'NGN',
                'callback_url' => route('paystack.callback'),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'user_id' => Auth::id(),
                    'invoice_reference' => $invoice->invoice_reference,
                    'purpose' => 'StackEase invoice payment',
                ],
            ]);

        if (! $response->successful() || $response->json('status') !== true) {
            return back()->with('error', 'Unable to initialize Paystack payment. Please try again.');
        }

        Payment::create([
            'user_id' => Auth::id(),
            'invoice_id' => $invoice->id,
            'payment_reference' => $reference,
            'gateway' => 'paystack',
            'amount' => $invoice->total_naira_amount,
            'currency' => 'NGN',
            'status' => 'pending',
            'payment_channel' => 'paystack',
            'gateway_response' => [
                'message' => 'Payment initialized via Paystack',
                'authorization_url' => $response->json('data.authorization_url'),
                'access_code' => $response->json('data.access_code'),
                'reference' => $reference,
            ],
        ]);

        return redirect($response->json('data.authorization_url'));
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (! $reference) {
            return redirect()
                ->route('dashboard.invoices')
                ->with('error', 'Missing payment reference.');
        }

        return $this->verifyAndFinalize($reference, true);
    }

    public function webhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');

        $computedSignature = hash_hmac(
            'sha512',
            $request->getContent(),
            config('services.paystack.secret_key')
        );

        if (! $signature || ! hash_equals($computedSignature, $signature)) {
            abort(401);
        }

        if ($request->input('event') === 'charge.success') {
            $reference = $request->input('data.reference');

            if ($reference) {
                $this->verifyAndFinalize($reference, false);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function verifyAndFinalize(string $reference, bool $shouldRedirect = true)
    {
        $payment = Payment::where('payment_reference', $reference)->first();

        if (! $payment) {
            return $shouldRedirect
                ? redirect()->route('dashboard.invoices')->with('error', 'Payment record not found.')
                : response()->json(['message' => 'Payment record not found.']);
        }

        $invoice = $payment->invoice;

        if (! $invoice) {
            return $shouldRedirect
                ? redirect()->route('dashboard.invoices')->with('error', 'Linked invoice not found.')
                : response()->json(['message' => 'Linked invoice not found.']);
        }

        if ($payment->isVerified() || $invoice->isPaid()) {
            return $shouldRedirect
                ? redirect()->route('dashboard.invoices.show', $invoice)->with('success', 'Payment already verified.')
                : response()->json(['message' => 'Payment already verified.']);
        }

        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.payment_url') . "/transaction/verify/{$reference}");

        if (! $response->successful() || $response->json('status') !== true) {
            return $shouldRedirect
                ? redirect()->route('dashboard.invoices.show', $invoice)->with('error', 'Unable to verify payment.')
                : response()->json(['message' => 'Unable to verify payment.']);
        }

        $data = $response->json('data');

        if (($data['status'] ?? null) !== 'success') {
            $payment->update([
                'status' => 'failed',
                'gateway_response' => [
                    'message' => $data['gateway_response'] ?? 'Payment failed or was not successful.',
                    'paystack_data' => $data,
                ],
            ]);

            return $shouldRedirect
                ? redirect()->route('dashboard.invoices.show', $invoice)->with('error', 'Payment was not successful.')
                : response()->json(['message' => 'Payment was not successful.']);
        }

        $paidAmount = ((int) $data['amount']) / 100;
        $expectedAmount = (float) $invoice->total_naira_amount;

        if ($paidAmount < $expectedAmount) {
            $payment->update([
                'amount' => $paidAmount,
                'status' => 'underpaid_action_required',
                'payment_channel' => $data['channel'] ?? 'paystack',
                'gateway_response' => [
                    'message' => $data['gateway_response'] ?? 'Underpayment detected.',
                    'expected_amount' => $expectedAmount,
                    'paid_amount' => $paidAmount,
                    'paystack_data' => $data,
                ],
                'paid_at' => $data['paid_at'] ?? now(),
            ]);

            $invoice->update([
                'status' => 'underpaid_action_required',
            ]);

            return $shouldRedirect
                ? redirect()->route('dashboard.invoices.show', $invoice)->with('error', 'Payment received, but the amount is lower than the invoice total. Admin review required.')
                : response()->json(['message' => 'Underpayment flagged.']);
        }

        if ($invoice->isExpired()) {
            $payment->update([
                'amount' => $paidAmount,
                'status' => 'expired_paid_flagged',
                'payment_channel' => $data['channel'] ?? 'paystack',
                'gateway_response' => [
                    'message' => $data['gateway_response'] ?? 'Payment received after invoice expiry.',
                    'expected_amount' => $expectedAmount,
                    'paid_amount' => $paidAmount,
                    'paystack_data' => $data,
                ],
                'paid_at' => $data['paid_at'] ?? now(),
            ]);

            $invoice->update([
                'status' => 'expired_paid_flagged',
            ]);

            return $shouldRedirect
                ? redirect()->route('dashboard.invoices.show', $invoice)->with('warning', 'Payment received after invoice expiry. Admin review required.')
                : response()->json(['message' => 'Expired payment flagged.']);
        }

        $payment->update([
            'amount' => $paidAmount,
            'status' => 'verified',
            'payment_channel' => $data['channel'] ?? 'paystack',
            'gateway_response' => [
                'message' => $data['gateway_response'] ?? 'Payment verified successfully.',
                'expected_amount' => $expectedAmount,
                'paid_amount' => $paidAmount,
                'paystack_data' => $data,
            ],
            'paid_at' => $data['paid_at'] ?? now(),
            'verified_at' => now(),
        ]);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return $shouldRedirect
            ? redirect()->route('dashboard.invoices.show', $invoice)->with('success', 'Payment verified successfully.')
            : response()->json(['message' => 'Payment verified successfully.']);
    }
}