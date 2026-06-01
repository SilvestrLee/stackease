<?php

namespace Database\Seeders;

use App\Models\Acknowledgment;
use App\Models\BatchWindow;
use App\Models\ConciergeRequest;
use App\Models\Invoice;
use App\Models\InvoicePricingSnapshot;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Provider;
use App\Models\Subscription;
use App\Models\SubscriptionCredential;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'demo@stackeasehq.com'],
            [
                'name' => 'Demo Customer',
                'phone' => '08000000000',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
                'user_type' => 'business',
                'preferred_contact_method' => 'whatsapp',
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('Business User');

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => 'Demo Creative Studio',
                'country' => 'Nigeria',
                'state' => 'Lagos',
                'city' => 'Ikeja',
                'business_type' => 'Creative Agency',
                'team_size' => '2-10',
                'whatsapp' => '08000000000',
                'notes' => 'Demo profile for testing StackEase business workflows.',
            ]
        );

        $provider = Provider::where('slug', 'canva')->first();
        $batchWindow = BatchWindow::where('name', 'Morning Batch')->first();

        $conciergeRequest = ConciergeRequest::updateOrCreate(
            ['request_reference' => 'REQ-DEMO-001'],
            [
                'user_id' => $user->id,
                'provider_id' => $provider?->id,
                'batch_window_id' => $batchWindow?->id,
                'service_name' => 'Canva Team Setup',
                'request_type' => 'subscription_setup',
                'desired_plan' => 'Canva Teams',
                'seat_count' => 3,
                'duration' => 'monthly',
                'budget_range' => '₦20,000 - ₦50,000',
                'existing_account' => false,
                'issue_description' => null,
                'user_notes' => 'We need Canva access for our small design team.',
                'admin_notes' => 'Demo concierge request.',
                'status' => 'quote_sent',
                'priority' => 'normal',
                'reviewed_at' => now(),
                'completed_at' => null,
            ]
        );

        $invoice = Invoice::updateOrCreate(
            ['invoice_reference' => 'INV-DEMO-001'],
            [
                'user_id' => $user->id,
                'concierge_request_id' => $conciergeRequest->id,
                'base_usd_cost' => 30.00,
                'fx_rate' => 1600.00,
                'fx_buffer_percent' => 10.00,
                'fx_buffer_amount' => 4800.00,
                'service_fee' => 5000.00,
                'gateway_fee' => 800.00,
                'total_naira_amount' => 58600.00,
                'currency' => 'NGN',
                'status' => 'sent',
                'sent_at' => now(),
                'expires_at' => now()->addDay(),
                'paid_at' => null,
                'notes' => 'Demo invoice for Canva Teams setup.',
            ]
        );

        InvoicePricingSnapshot::updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'provider_cost_amount' => 30.00,
                'provider_cost_currency' => 'USD',
                'fx_rate' => 1600.00,
                'local_provider_cost' => 48000.00,
                'fx_buffer_percent' => 10.00,
                'fx_buffer_amount' => 4800.00,
                'service_fee' => 5000.00,
                'gateway_fee' => 800.00,
                'final_total' => 58600.00,
                'rate_source' => 'manual_demo_rate',
                'valid_until' => now()->addDay(),
                'metadata' => [
                    'note' => 'Demo pricing snapshot for testing only.',
                ],
            ]
        );

        $payment = Payment::updateOrCreate(
            ['payment_reference' => 'PAY-DEMO-001'],
            [
                'user_id' => $user->id,
                'invoice_id' => $invoice->id,
                'gateway' => 'manual_transfer',
                'amount' => 58600.00,
                'currency' => 'NGN',
                'status' => 'manually_confirmed',
                'payment_channel' => 'bank_transfer',
                'proof_of_payment_path' => null,
                'gateway_response' => [
                    'demo' => true,
                    'message' => 'Manual payment confirmed for demo data.',
                ],
                'paid_at' => now(),
                'verified_by' => User::where('email', 'admin@stackeasehq.com')->first()?->id,
                'verified_at' => now(),
            ]
        );

        $invoice->update([
            'status' => 'paid',
            'paid_at' => $payment->paid_at,
        ]);

        $subscription = Subscription::updateOrCreate(
            ['subscription_reference' => 'SUB-DEMO-001'],
            [
                'user_id' => $user->id,
                'provider_id' => $provider?->id,
                'concierge_request_id' => $conciergeRequest->id,
                'invoice_id' => $invoice->id,
                'provider_name' => 'Canva',
                'plan_type' => 'Canva Teams',
                'seat_count' => 3,
                'start_date' => now()->toDateString(),
                'renewal_date' => now()->addMonth()->toDateString(),
                'amount' => 58600.00,
                'currency' => 'NGN',
                'status' => 'active',
                'access_note' => 'Your Canva Teams invitation has been sent to your email.',
                'internal_note' => 'Demo subscription created by DemoDataSeeder.',
            ]
        );

        SubscriptionCredential::updateOrCreate(
            ['subscription_id' => $subscription->id],
            [
                'encrypted_access_payload' => Crypt::encryptString(json_encode([
                    'type' => 'invitation_link',
                    'message' => 'Demo encrypted invitation payload. Do not use real credentials in seeders.',
                    'invitation_url' => 'https://example.com/demo-invite',
                ])),
                'payload_type' => 'invitation_link',
                'last_viewed_at' => null,
                'last_viewed_by' => null,
            ]
        );

        Acknowledgment::updateOrCreate(
            [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'acknowledgment_type' => 'setup_access',
            ],
            [
                'invoice_id' => $invoice->id,
                'terms_version' => 'v1.0',
                'acknowledgment_text' => 'I understand that StackEase manages setup support and access delivery according to the stated terms.',
                'accepted_at' => now(),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Demo Seeder',
            ]
        );

        $ticket = SupportTicket::updateOrCreate(
            ['ticket_reference' => 'TIC-DEMO-001'],
            [
                'user_id' => $user->id,
                'concierge_request_id' => $conciergeRequest->id,
                'subscription_id' => $subscription->id,
                'subject' => 'Canva invitation not seen yet',
                'message' => 'Hello, I have not seen the Canva invitation in my inbox yet.',
                'ticket_type' => 'access_problem',
                'priority' => 'normal',
                'status' => 'open',
                'assigned_to' => User::where('email', 'admin@stackeasehq.com')->first()?->id,
                'resolved_at' => null,
                'closed_at' => null,
            ]
        );

        TicketReply::updateOrCreate(
            [
                'support_ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'message' => 'Hello, I have checked spam but still cannot find it.',
            ],
            [
                'is_internal_note' => false,
                'attachments' => null,
            ]
        );
    }
}