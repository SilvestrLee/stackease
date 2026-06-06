@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>My Subscriptions</h1>
    <p>View your active, pending, and renewal-related StackEase subscriptions.</p>
</div>

<section class="sd-card sd-card-pad">
    <div class="sd-section-title">
        <h2>Subscription Records</h2>
        <a href="{{ route('concierge') }}">Request new setup →</a>
    </div>

    <div class="sd-subscription-list">
        @forelse ($subscriptions as $subscription)
            <article class="sd-subscription-record">
                <div class="sd-subscription-record-main">
                    <div class="sd-subscription-record-icon">
                        {{ strtoupper(substr($subscription->provider?->name ?? $subscription->name ?? 'S', 0, 1)) }}
                    </div>

                    <div>
                        <h3>{{ $subscription->provider?->name ?? $subscription->name ?? 'Subscription' }}</h3>
                        <p>{{ $subscription->subscription_reference ?? 'SUB-' . str_pad($subscription->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="sd-subscription-record-grid">
                    <div>
                        <span>Provider</span>
                        <strong>{{ $subscription->provider?->name ?? 'Not assigned' }}</strong>
                    </div>

                    <div>
                        <span>Plan</span>
                        <strong>{{ $subscription->plan_name ?? 'Managed Plan' }}</strong>
                    </div>

                    <div>
                        <span>Seats</span>
                        <strong>{{ $subscription->seat_count ?? 1 }}</strong>
                    </div>

                    <div>
                        <span>Amount</span>
                        <strong>
                            ₦{{ number_format((float) ($subscription->amount ?? 0), 2) }}
                        </strong>
                    </div>

                    <div>
                        <span>Start Date</span>
                        <strong>
                            {{ $subscription->start_date ? \Carbon\Carbon::parse($subscription->start_date)->format('M d, Y') : 'Not set' }}
                        </strong>
                    </div>

                    <div>
                        <span>Renewal Date</span>
                        <strong>
                            {{ $subscription->renewal_date ? \Carbon\Carbon::parse($subscription->renewal_date)->format('M d, Y') : 'Not set' }}
                        </strong>
                    </div>
                </div>

                @if (! empty($subscription->access_note))
                    <div class="sd-access-note">
                        <span>Access / Setup Note</span>
                        <p>{{ $subscription->access_note }}</p>
                    </div>
                @endif

                <div class="sd-subscription-record-side">
                    <span class="sd-status">
                        {{ str_replace('_', ' ', Str::title($subscription->status)) }}
                    </span>

                    @if ($subscription->invoice)
                        <a href="{{ route('dashboard.invoices.show', $subscription->invoice) }}">
                            View Invoice
                        </a>
                    @endif
                </div>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No subscriptions yet</strong>
                <p>Your subscriptions will appear here after StackEase completes your setup.</p>
                <a href="{{ route('concierge') }}">Request setup help</a>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-subscription-list {
        display: grid;
        gap: 16px;
    }

    .sd-subscription-record {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 180px;
        gap: 24px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-subscription-record-main {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .sd-subscription-record-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #18c7a7, #6366f1);
        color: #ffffff;
        font-weight: 900;
    }

    .sd-subscription-record h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 850;
        letter-spacing: -0.03em;
        color: #0f172a;
    }

    .sd-subscription-record p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .sd-subscription-record-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-subscription-record-grid span,
    .sd-access-note span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-subscription-record-grid strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 750;
    }

    .sd-access-note {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-access-note p {
        margin: 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-subscription-record-side {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 14px;
        padding: 18px;
        border-radius: 16px;
        background: #f8fafc;
    }

    .sd-subscription-record-side a {
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

    @media (max-width: 900px) {
        .sd-subscription-record {
            grid-template-columns: 1fr;
        }

        .sd-subscription-record-grid {
            grid-template-columns: 1fr;
        }

        .sd-subscription-record-side {
            align-items: flex-start;
        }
    }
</style>

@endsection