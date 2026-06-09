<?php

use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/services', [PublicPageController::class, 'services'])->name('services');

Route::get('/deals', [PublicPageController::class, 'deals'])->name('deals');

Route::get('/deals/{slug}', [PublicPageController::class, 'dealShow'])->name('deals.show');

Route::get('/resources', [PublicPageController::class, 'resources'])->name('resources.index');

Route::get('/resources/{slug}', [PublicPageController::class, 'resourceShow'])->name('resources.show');

Route::get('/concierge-request', [PublicPageController::class, 'concierge'])->name('concierge');

Route::post('/concierge-request', [PublicPageController::class, 'storeConciergeRequest'])
    ->middleware(['auth', 'verified'])
    ->name('concierge.store');

Route::get('/managed-subscriptions', [PublicPageController::class, 'managedSubscriptions'])->name('managed-subscriptions');

Route::get('/terms-of-use', [PublicPageController::class, 'terms'])->name('policies.terms');

Route::get('/privacy-policy', [PublicPageController::class, 'privacy'])->name('policies.privacy');

Route::get('/refund-policy', [PublicPageController::class, 'refund'])->name('policies.refund');

Route::get('/subscription-policy', [PublicPageController::class, 'subscriptionPolicy'])->name('policies.subscription');

Route::get('/acceptable-use-policy', [PublicPageController::class, 'acceptableUse'])->name('policies.acceptable-use');

Route::get('/disclaimer', [PublicPageController::class, 'disclaimer'])->name('policies.disclaimer');

/*
|--------------------------------------------------------------------------
| Paystack Webhook
|--------------------------------------------------------------------------
| This route must stay outside auth middleware because Paystack will call it
| directly from its own server.
|--------------------------------------------------------------------------
*/

Route::post('/payments/paystack/webhook', [PaystackPaymentController::class, 'webhook'])
    ->name('paystack.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard/requests', function () {
        return view('dashboard.requests', [
            'requests' => auth()->user()
                ->conciergeRequests()
                ->with(['provider', 'batchWindow', 'invoices'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.requests');

    Route::get('/dashboard/invoices', function () {
        return view('dashboard.invoices', [
            'invoices' => auth()->user()
                ->invoices()
                ->with(['conciergeRequest'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.invoices');

    Route::get('/dashboard/invoices/{invoice}', function (Invoice $invoice) {
        abort_unless($invoice->user_id === auth()->id(), 403);

        $invoice->load([
            'conciergeRequest',
            'pricingSnapshot',
            'payments',
        ]);

        return view('dashboard.invoice-show', [
            'invoice' => $invoice,
        ]);
    })->name('dashboard.invoices.show');

    /*
    |--------------------------------------------------------------------------
    | Paystack Payment Routes
    |--------------------------------------------------------------------------
    */

    Route::post('/invoices/{invoice}/pay/paystack', [PaystackPaymentController::class, 'initialize'])
        ->name('paystack.initialize');

    Route::get('/payments/paystack/callback', [PaystackPaymentController::class, 'callback'])
        ->name('paystack.callback');

    /*
    |--------------------------------------------------------------------------
    | Manual Payment Proof Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/payment-proofs', function () {
        $user = auth()->user();

        return view('dashboard.payment-proofs', [
            'invoices' => $user->invoices()
                ->whereIn('status', ['sent', 'awaiting_payment', 'expired_paid_flagged', 'underpaid_action_required'])
                ->latest()
                ->get(),

            'payments' => $user->payments()
                ->with('invoice')
                ->where('gateway', 'bank_transfer')
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.payment-proofs');

    Route::post('/dashboard/payment-proofs', function (Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'proof_of_payment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,webp', 'max:5120'],
        ]);

        $invoice = $user->invoices()
            ->where('id', $validated['invoice_id'])
            ->whereIn('status', ['sent', 'awaiting_payment', 'expired_paid_flagged', 'underpaid_action_required'])
            ->firstOrFail();

        $proofPath = $request->file('proof_of_payment')->store('payment-proofs', 'public');

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->invoice_id = $invoice->id;
        $payment->payment_reference = 'PAY-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
        $payment->gateway = 'bank_transfer';
        $payment->amount = $validated['amount'];
        $payment->currency = $invoice->currency ?? 'NGN';
        $payment->status = 'pending';
        $payment->payment_channel = 'manual_bank_transfer';
        $payment->proof_of_payment_path = $proofPath;
        $payment->paid_at = now();
        $payment->gateway_response = [
            'source' => 'user_uploaded_payment_proof',
            'submitted_at' => now()->toDateTimeString(),
        ];
        $payment->save();

        return redirect()
            ->route('dashboard.payment-proofs')
            ->with('status', 'Payment proof uploaded successfully. StackEase will review and verify it.');
    })->name('dashboard.payment-proofs.store');

    Route::get('/dashboard/subscriptions', function () {
        return view('dashboard.subscriptions', [
            'subscriptions' => auth()->user()
                ->subscriptions()
                ->with(['provider', 'invoice'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.subscriptions');

    Route::get('/dashboard/tickets', function () {
        return view('dashboard.tickets', [
            'tickets' => auth()->user()
                ->supportTickets()
                ->with(['subscription', 'conciergeRequest'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.tickets');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';