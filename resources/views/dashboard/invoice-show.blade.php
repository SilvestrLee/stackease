@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>Invoice Details</h1>
    <p>Review invoice pricing, payment status, and payment records.</p>
</div>

@if(session('success'))
    <div class="sd-alert sd-alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="sd-alert sd-alert-error">
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="sd-alert sd-alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('status'))
    <div class="sd-alert sd-alert-info">
        {{ session('status') }}
    </div>
@endif

<div class="sd-detail-actions">
    <a href="{{ route('dashboard.invoices') }}">← Back to invoices</a>
</div>

<div class="sd-invoice-detail-grid">
    <section class="sd-card sd-card-pad">
        <div class="sd-section-title">
            <h2>{{ $invoice->invoice_reference ?? 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</h2>

            <span class="sd-status sd-status--{{ $invoice->status }}">
                {{ str_replace('_', ' ', Str::title($invoice->status)) }}
            </span>
        </div>

        <div class="sd-invoice-summary">
            <div>
                <span>Request</span>
                <strong>
                    {{ $invoice->conciergeRequest?->service_name 
                        ?? $invoice->conciergeRequest?->provider?->name 
                        ?? 'StackEase Request' 
                    }}
                </strong>
            </div>

            <div>
                <span>Currency</span>
                <strong>{{ $invoice->currency ?? 'NGN' }}</strong>
            </div>

            <div>
                <span>Base USD Cost</span>
                <strong>${{ number_format((float) ($invoice->base_usd_cost ?? 0), 2) }}</strong>
            </div>

            <div>
                <span>FX Rate</span>
                <strong>₦{{ number_format((float) ($invoice->fx_rate ?? 0), 2) }}</strong>
            </div>

            <div>
                <span>FX Buffer</span>
                <strong>{{ number_format((float) ($invoice->fx_buffer_percent ?? 0), 2) }}%</strong>
            </div>

            <div>
                <span>FX Buffer Amount</span>
                <strong>₦{{ number_format((float) ($invoice->fx_buffer_amount ?? 0), 2) }}</strong>
            </div>

            <div>
                <span>Service Fee</span>
                <strong>₦{{ number_format((float) ($invoice->service_fee ?? 0), 2) }}</strong>
            </div>

            <div>
                <span>Gateway Fee</span>
                <strong>₦{{ number_format((float) ($invoice->gateway_fee ?? 0), 2) }}</strong>
            </div>

            <div>
                <span>Sent At</span>
                <strong>{{ $invoice->sent_at ? \Carbon\Carbon::parse($invoice->sent_at)->format('M d, Y h:i A') : 'Not sent' }}</strong>
            </div>

            <div>
                <span>Expires At</span>
                <strong>{{ $invoice->expires_at ? \Carbon\Carbon::parse($invoice->expires_at)->format('M d, Y h:i A') : 'Not set' }}</strong>
            </div>

            <div>
                <span>Paid At</span>
                <strong>{{ $invoice->paid_at ? \Carbon\Carbon::parse($invoice->paid_at)->format('M d, Y h:i A') : 'Not paid' }}</strong>
            </div>

            <div>
                <span>Created</span>
                <strong>{{ $invoice->created_at?->format('M d, Y h:i A') }}</strong>
            </div>
        </div>

        @if (! empty($invoice->notes))
            <div class="sd-invoice-note-box">
                <span>Invoice Note</span>
                <p>{{ $invoice->notes }}</p>
            </div>
        @endif

        @if ($invoice->pricingSnapshot)
            <div class="sd-pricing-snapshot">
                <h3>Pricing Snapshot</h3>

                <div class="sd-invoice-summary">
                    <div>
                        <span>Provider Cost</span>
                        <strong>
                            {{ $invoice->pricingSnapshot->provider_cost_currency ?? 'USD' }}
                            {{ number_format((float) ($invoice->pricingSnapshot->provider_cost_amount ?? 0), 2) }}
                        </strong>
                    </div>

                    <div>
                        <span>Local Provider Cost</span>
                        <strong>₦{{ number_format((float) ($invoice->pricingSnapshot->local_provider_cost ?? 0), 2) }}</strong>
                    </div>

                    <div>
                        <span>Snapshot FX Rate</span>
                        <strong>₦{{ number_format((float) ($invoice->pricingSnapshot->fx_rate ?? 0), 2) }}</strong>
                    </div>

                    <div>
                        <span>Final Total</span>
                        <strong>₦{{ number_format((float) ($invoice->pricingSnapshot->final_total ?? 0), 2) }}</strong>
                    </div>

                    <div>
                        <span>Rate Source</span>
                        <strong>{{ $invoice->pricingSnapshot->rate_source ?? 'Manual admin rate' }}</strong>
                    </div>

                    <div>
                        <span>Valid Until</span>
                        <strong>
                            {{ $invoice->pricingSnapshot->valid_until 
                                ? \Carbon\Carbon::parse($invoice->pricingSnapshot->valid_until)->format('M d, Y h:i A') 
                                : 'Not set' 
                            }}
                        </strong>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <aside class="sd-side-stack">
        <section class="sd-card sd-card-pad sd-payment-card">
            <span>Total Amount Due</span>

            <strong>
                ₦{{ number_format((float) ($invoice->total_naira_amount ?? $invoice->amount ?? 0), 2) }}
            </strong>

            @if ($invoice->isPayable() && ! $invoice->isPaid())
                <p>
                    Pay securely online using Paystack. Your invoice will be verified automatically after payment.
                </p>

                <form method="POST" action="{{ route('paystack.initialize', $invoice) }}">
                    @csrf

                    <button type="submit" class="sd-paystack-button">
                        Pay Online with Paystack
                    </button>
                </form>

                <a href="{{ route('dashboard.payment-proofs') }}" class="sd-manual-payment-link">
                    Prefer bank transfer? Upload payment proof
                </a>
            @elseif ($invoice->status === 'paid')
                <p>This invoice has been paid and confirmed.</p>
            @elseif ($invoice->status === 'expired_paid_flagged')
                <p>Payment was received after invoice expiry. StackEase will review this manually.</p>
            @elseif ($invoice->status === 'underpaid_action_required')
                <p>Payment received is lower than the invoice total. Admin review is required.</p>
            @elseif ($invoice->status === 'expired')
                <p>This invoice has expired. You may still attempt payment, but it will require admin review.</p>

                <form method="POST" action="{{ route('paystack.initialize', $invoice) }}">
                    @csrf

                    <button type="submit" class="sd-paystack-button sd-paystack-button-warning">
                        Pay Expired Invoice
                    </button>
                </form>
            @else
                <p>Current invoice status: {{ str_replace('_', ' ', Str::title($invoice->status)) }}.</p>
            @endif
        </section>

        <section class="sd-card sd-card-pad">
            <div class="sd-section-title">
                <h2>Payment Records</h2>
            </div>

            <div class="sd-payment-list">
                @forelse ($invoice->payments as $payment)
                    <article class="sd-payment-item">
                        <div>
                            <strong>{{ $payment->payment_reference ?? 'PAY-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            <small>{{ Str::title(str_replace('_', ' ', $payment->gateway ?? 'Manual')) }}</small>
                        </div>

                        <span class="sd-status sd-status--{{ $payment->status }}">
                            {{ Str::title(str_replace('_', ' ', $payment->status)) }}
                        </span>

                        <p>
                            ₦{{ number_format((float) ($payment->amount ?? 0), 2) }}
                        </p>

                        <small>
                            {{ $payment->paid_at 
                                ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') 
                                : $payment->created_at?->format('M d, Y h:i A') 
                            }}
                        </small>
                    </article>
                @empty
                    <p class="sd-muted-text">No payment has been recorded for this invoice yet.</p>
                @endforelse
            </div>
        </section>

        <section class="sd-card sd-card-pad sd-help-panel">
            <div>
                <h2>Need help?</h2>
                <p>Open a support ticket if you need help with this invoice.</p>
                <a href="{{ route('dashboard.tickets') }}">Create Support Ticket</a>
            </div>
        </section>
    </aside>
</div>

<style>
    .sd-alert {
        margin: 0 0 18px;
        padding: 13px 15px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.5;
    }

    .sd-alert-success {
        background: rgba(34, 197, 94, 0.10);
        border: 1px solid rgba(34, 197, 94, 0.20);
        color: #047857;
    }

    .sd-alert-error {
        background: rgba(239, 68, 68, 0.10);
        border: 1px solid rgba(239, 68, 68, 0.20);
        color: #dc2626;
    }

    .sd-alert-warning {
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.22);
        color: #b45309;
    }

    .sd-alert-info {
        background: rgba(14, 165, 233, 0.10);
        border: 1px solid rgba(14, 165, 233, 0.20);
        color: #0369a1;
    }

    .sd-detail-actions {
        margin: -10px 0 20px;
    }

    .sd-detail-actions a {
        display: inline-flex;
        color: #008f7a;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
    }

    .sd-invoice-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 20px;
    }

    .sd-invoice-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .sd-invoice-summary div {
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-invoice-summary span,
    .sd-invoice-note-box span {
        display: block;
        margin-bottom: 7px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-invoice-summary strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .sd-invoice-note-box {
        margin-top: 18px;
        padding: 16px;
        border-radius: 14px;
        background: rgba(24, 199, 167, 0.07);
        border: 1px solid rgba(24, 199, 167, 0.16);
    }

    .sd-invoice-note-box p {
        margin: 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-pricing-snapshot {
        margin-top: 26px;
    }

    .sd-pricing-snapshot h3 {
        margin: 0 0 16px;
        font-size: 16px;
        font-weight: 850;
        letter-spacing: -0.025em;
        color: #0f172a;
    }

    .sd-payment-card > span {
        display: block;
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .sd-payment-card > strong {
        display: block;
        color: #0f172a;
        font-size: 34px;
        line-height: 1;
        letter-spacing: -0.05em;
        margin-bottom: 14px;
    }

    .sd-payment-card p {
        margin: 0 0 18px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-payment-card form {
        margin: 0;
    }

    .sd-payment-card button,
    .sd-paystack-button {
        width: 100%;
        height: 42px;
        border: 0;
        border-radius: 999px;
        background: #008f7a;
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sd-payment-card button:hover,
    .sd-paystack-button:hover {
        background: #007666;
        transform: translateY(-1px);
    }

    .sd-paystack-button-warning {
        background: #b45309;
    }

    .sd-paystack-button-warning:hover {
        background: #92400e;
    }

    .sd-manual-payment-link {
        display: flex;
        justify-content: center;
        margin-top: 12px;
        color: #008f7a;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .sd-manual-payment-link:hover {
        text-decoration: underline;
    }

    .sd-payment-list {
        display: grid;
        gap: 12px;
    }

    .sd-payment-item {
        padding: 14px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-payment-item strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .sd-payment-item small {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-top: 5px;
    }

    .sd-payment-item p {
        margin: 10px 0 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 850;
    }

    .sd-status--paid,
    .sd-status--verified {
        background: rgba(34, 197, 94, 0.12);
        color: #047857;
    }

    .sd-status--pending,
    .sd-status--awaiting_payment,
    .sd-status--sent {
        background: rgba(245, 158, 11, 0.14);
        color: #b45309;
    }

    .sd-status--expired,
    .sd-status--cancelled,
    .sd-status--rejected,
    .sd-status--failed,
    .sd-status--refunded,
    .sd-status--underpaid_action_required,
    .sd-status--expired_paid_flagged {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    @media (max-width: 1100px) {
        .sd-invoice-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 720px) {
        .sd-invoice-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection