@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>Invoice Details</h1>
    <p>Review invoice pricing, payment status, and payment records.</p>
</div>

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
                <strong>₦{{ number_format((float) ($invoice->fx_buffer_applied ?? 0), 2) }}</strong>
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

            @if (in_array($invoice->status, ['sent', 'awaiting_payment']))
                <p>This invoice is awaiting payment. Paystack payment will be connected in the next payment phase.</p>

                <button type="button" disabled>
                    Pay Now Coming Soon
                </button>
            @elseif ($invoice->status === 'paid')
                <p>This invoice has been paid and confirmed.</p>
            @elseif ($invoice->status === 'expired')
                <p>This invoice has expired. Please contact StackEase or submit a new request.</p>
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

    .sd-payment-card button {
        width: 100%;
        height: 42px;
        border: 0;
        border-radius: 999px;
        background: #cbd5e1;
        color: #475569;
        font-size: 13px;
        font-weight: 850;
        cursor: not-allowed;
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
    .sd-status--refunded {
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