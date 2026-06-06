@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>My Invoices</h1>
    <p>View your StackEase invoices, payment status, and invoice details.</p>
</div>

<section class="sd-card sd-card-pad">
    <div class="sd-section-title">
        <h2>Invoice Records</h2>
        <a href="{{ route('concierge') }}">Request new setup →</a>
    </div>

    <div class="sd-invoice-list">
        @forelse ($invoices as $invoice)
            <article class="sd-invoice-record">
                <div class="sd-invoice-main">
                    <div class="sd-invoice-icon">
                        ₦
                    </div>

                    <div>
                        <h3>{{ $invoice->invoice_reference ?? 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</h3>
                        <p>
                            {{ $invoice->conciergeRequest?->service_name 
                                ?? $invoice->conciergeRequest?->provider?->name 
                                ?? 'StackEase Invoice' 
                            }}
                        </p>
                    </div>
                </div>

                <div class="sd-invoice-grid">
                    <div>
                        <span>Amount</span>
                        <strong>₦{{ number_format((float) ($invoice->total_naira_amount ?? $invoice->amount ?? 0), 2) }}</strong>
                    </div>

                    <div>
                        <span>Currency</span>
                        <strong>{{ $invoice->currency ?? 'NGN' }}</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong>{{ str_replace('_', ' ', Str::title($invoice->status)) }}</strong>
                    </div>

                    <div>
                        <span>Issued</span>
                        <strong>{{ $invoice->created_at?->format('M d, Y') }}</strong>
                    </div>

                    <div>
                        <span>Expires</span>
                        <strong>{{ $invoice->expires_at ? \Carbon\Carbon::parse($invoice->expires_at)->format('M d, Y h:i A') : 'Not set' }}</strong>
                    </div>

                    <div>
                        <span>Paid At</span>
                        <strong>{{ $invoice->paid_at ? \Carbon\Carbon::parse($invoice->paid_at)->format('M d, Y h:i A') : 'Not paid' }}</strong>
                    </div>
                </div>

                @if (! empty($invoice->notes))
                    <div class="sd-invoice-note">
                        <span>Invoice Note</span>
                        <p>{{ $invoice->notes }}</p>
                    </div>
                @endif

                <div class="sd-invoice-side">
                    <span class="sd-status sd-status--{{ $invoice->status }}">
                        {{ str_replace('_', ' ', Str::title($invoice->status)) }}
                    </span>

                    <a href="{{ route('dashboard.invoices.show', $invoice) }}">
                        View Invoice
                    </a>

                    @if (in_array($invoice->status, ['sent', 'awaiting_payment']))
                        <small>Payment required</small>
                    @elseif ($invoice->status === 'paid')
                        <small>Payment confirmed</small>
                    @elseif ($invoice->status === 'expired')
                        <small>Invoice expired</small>
                    @endif
                </div>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No invoices yet</strong>
                <p>Your invoices will appear here after StackEase reviews your request.</p>
                <a href="{{ route('concierge') }}">Create request</a>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-invoice-list {
        display: grid;
        gap: 16px;
    }

    .sd-invoice-record {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 180px;
        gap: 24px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-invoice-main {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .sd-invoice-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a;
        font-weight: 900;
        font-size: 22px;
    }

    .sd-invoice-record h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 850;
        letter-spacing: -0.03em;
        color: #0f172a;
    }

    .sd-invoice-record p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .sd-invoice-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-invoice-grid span,
    .sd-invoice-note span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-invoice-grid strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 750;
    }

    .sd-invoice-note {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-invoice-note p {
        margin: 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-invoice-side {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 14px;
        padding: 18px;
        border-radius: 16px;
        background: #f8fafc;
    }

    .sd-invoice-side a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        padding: 0 14px;
        border-radius: 999px;
        background: #18c7a7;
        color: #020617;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .sd-invoice-side small {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-status--paid,
    .sd-status--verified {
        background: rgba(34, 197, 94, 0.12);
        color: #047857;
    }

    .sd-status--awaiting_payment,
    .sd-status--sent {
        background: rgba(245, 158, 11, 0.14);
        color: #b45309;
    }

    .sd-status--expired,
    .sd-status--cancelled,
    .sd-status--refunded {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    @media (max-width: 900px) {
        .sd-invoice-record {
            grid-template-columns: 1fr;
        }

        .sd-invoice-grid {
            grid-template-columns: 1fr;
        }

        .sd-invoice-side {
            align-items: flex-start;
        }
    }
</style>

@endsection