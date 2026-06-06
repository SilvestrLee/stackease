@extends('layouts.dashboard')

@section('content')

@php
    $user = auth()->user();

    $pendingRequests = $user->conciergeRequests()
        ->whereIn('status', ['submitted', 'under_review', 'awaiting_payment', 'in_progress'])
        ->count();

    $unpaidInvoices = $user->invoices()
        ->whereIn('status', ['sent', 'awaiting_payment'])
        ->count();

    $activeSubscriptions = $user->subscriptions()
        ->where('status', 'active')
        ->count();

    $renewalsDueSoon = $user->subscriptions()
        ->where('status', 'active')
        ->whereNotNull('renewal_date')
        ->whereBetween('renewal_date', [now(), now()->addDays(30)])
        ->count();

    $recentRequests = $user->conciergeRequests()
        ->with('provider')
        ->latest()
        ->take(4)
        ->get();

    $recentInvoices = $user->invoices()
        ->latest()
        ->take(3)
        ->get();

    $activeSubscriptionList = $user->subscriptions()
        ->with('provider')
        ->where('status', 'active')
        ->latest()
        ->take(5)
        ->get();

    $openTickets = $user->supportTickets()
        ->whereIn('status', ['open', 'pending', 'in_progress'])
        ->count();
@endphp

<div class="sd-page-title">
    <h1>Welcome back, {{ explode(' ', $user->name)[0] }}! 👋</h1>
    <p>Here’s what’s happening with your StackEase account today.</p>
</div>

<div class="sd-metrics-grid">
    <article class="sd-metric-card sd-card">
        <div class="sd-metric-icon">▣</div>
        <div>
            <p>Pending Requests</p>
            <strong>{{ $pendingRequests }}</strong>
            <span>Awaiting review</span>
        </div>
    </article>

    <article class="sd-metric-card sd-card">
        <div class="sd-metric-icon sd-metric-icon--danger">▤</div>
        <div>
            <p>Unpaid Invoices</p>
            <strong>{{ $unpaidInvoices }}</strong>
            <span>Needs payment</span>
        </div>
    </article>

    <article class="sd-metric-card sd-card">
        <div class="sd-metric-icon sd-metric-icon--success">◇</div>
        <div>
            <p>Active Subscriptions</p>
            <strong>{{ $activeSubscriptions }}</strong>
            <span>All running smoothly</span>
        </div>
    </article>

    <article class="sd-metric-card sd-card">
        <div class="sd-metric-icon sd-metric-icon--purple">□</div>
        <div>
            <p>Renewals Due Soon</p>
            <strong>{{ $renewalsDueSoon }}</strong>
            <span>Next 30 days</span>
        </div>
    </article>
</div>

<div class="sd-overview-grid">
    <section class="sd-card sd-card-pad">
        <div class="sd-section-title">
            <h2>My Recent Requests</h2>
            <a href="{{ route('dashboard.requests') }}">View all requests →</a>
        </div>

        <div class="sd-request-table">
            <div class="sd-request-head">
                <span>Request</span>
                <span>Service</span>
                <span>Status</span>
                <span>Last Update</span>
                <span></span>
            </div>

            @forelse ($recentRequests as $request)
                <div class="sd-request-row">
                    <div class="sd-request-main">
                        <span class="sd-request-avatar">
                            {{ strtoupper(substr($request->provider?->name ?? $request->service_name ?? 'S', 0, 1)) }}
                        </span>
                        <div>
                            <strong>{{ $request->request_reference ?? 'REQ-' . str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            <small>{{ $request->created_at?->format('M d, Y') }}</small>
                        </div>
                    </div>

                    <div>
                        <strong>{{ $request->provider?->name ?? $request->service_name ?? 'Custom Request' }}</strong>
                        <small>{{ $request->seat_count ?? 1 }} {{ Str::plural('seat', $request->seat_count ?? 1) }}</small>
                    </div>

                    <div>
                        <span class="sd-status">{{ str_replace('_', ' ', Str::title($request->status)) }}</span>
                    </div>

                    <div>
                        <span>{{ $request->updated_at?->format('M d, Y') }}</span>
                        <small>{{ $request->updated_at?->format('h:i A') }}</small>
                    </div>

                    <a href="{{ route('dashboard.requests') }}">›</a>
                </div>
            @empty
                <div class="sd-empty">
                    <strong>No requests yet</strong>
                    <p>Submit your first concierge request to get started.</p>
                    <a href="{{ route('concierge') }}">Create request</a>
                </div>
            @endforelse
        </div>
    </section>

    <aside class="sd-side-stack">
        <section class="sd-card sd-card-pad">
            <h2 class="sd-side-title">Account Status</h2>

            <div class="sd-account-status">
                <div>🛡</div>
                <div>
                    <strong>Account Verified</strong>
                    <p>You’re all set to enjoy our services.</p>
                </div>
            </div>
        </section>

        <section class="sd-card sd-card-pad">
            <div class="sd-section-title">
                <h2>Recent Activity</h2>
            </div>

            <div class="sd-activity-list">
                @forelse ($recentInvoices as $invoice)
                    <div class="sd-activity-item">
                        <span>✓</span>
                        <div>
                            <strong>Invoice {{ $invoice->invoice_reference ?? '#' . $invoice->id }}</strong>
                            <small>{{ Str::title(str_replace('_', ' ', $invoice->status)) }} · {{ $invoice->updated_at?->format('M d, Y') }}</small>
                        </div>
                    </div>
                @empty
                    <p class="sd-muted-text">No recent invoice activity yet.</p>
                @endforelse
            </div>

            <a class="sd-side-link" href="{{ route('dashboard.invoices') }}">View invoices →</a>
        </section>

        <section class="sd-card sd-card-pad sd-help-panel">
            <div>
                <h2>Need Help?</h2>
                <p>Our support team is here to help you with anything you need.</p>
                <a href="{{ route('dashboard.tickets') }}">Create Support Ticket</a>
            </div>
            <div class="sd-help-illustration">🎧</div>
        </section>
    </aside>
</div>

<section class="sd-card sd-card-pad sd-subscription-section">
    <div class="sd-section-title">
        <h2>Your Active Subscriptions</h2>
        <a href="{{ route('dashboard.subscriptions') }}">View all subscriptions →</a>
    </div>

    <div class="sd-subscription-row">
        @forelse ($activeSubscriptionList as $subscription)
            <article class="sd-subscription-card">
                <div class="sd-subscription-logo">
                    {{ strtoupper(substr($subscription->provider?->name ?? $subscription->name ?? 'S', 0, 1)) }}
                </div>

                <div>
                    <strong>{{ $subscription->provider?->name ?? $subscription->name ?? 'Subscription' }}</strong>
                    <small>{{ $subscription->plan_name ?? 'Managed Plan' }}</small>
                </div>

                <p>
                    Renews on
                    {{ $subscription->renewal_date ? $subscription->renewal_date->format('M d, Y') : 'Not set' }}
                </p>

                <span class="sd-status">Active</span>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No active subscriptions yet</strong>
                <p>Your active subscriptions will appear here once setup is completed.</p>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 14px;
    }

    .sd-metric-card {
        min-height: 132px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .sd-metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: rgba(24, 199, 167, 0.12);
        color: #008f7a;
        font-size: 22px;
        flex-shrink: 0;
    }

    .sd-metric-icon--danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .sd-metric-icon--success {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .sd-metric-icon--purple {
        background: rgba(124, 58, 237, 0.1);
        color: #7c3aed;
    }

    .sd-metric-card p {
        margin: 0 0 22px;
        font-size: 13px;
        color: #0f172a;
        font-weight: 650;
    }

    .sd-metric-card strong {
        display: block;
        font-size: 28px;
        line-height: 1;
        margin-bottom: 12px;
        letter-spacing: -0.04em;
    }

    .sd-metric-card span {
        color: #008f7a;
        font-size: 13px;
        font-weight: 600;
    }

    .sd-overview-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 344px;
        gap: 20px;
        margin-bottom: 20px;
    }

    .sd-request-table {
        display: grid;
    }

    .sd-request-head,
    .sd-request-row {
        display: grid;
        grid-template-columns: 1.15fr 1fr 0.8fr 1fr 28px;
        gap: 16px;
        align-items: center;
    }

    .sd-request-head {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
    }

    .sd-request-row {
        padding: 14px 0;
        border-bottom: 1px solid rgba(15, 23, 42, 0.07);
    }

    .sd-request-row:last-child {
        border-bottom: 0;
    }

    .sd-request-row strong,
    .sd-request-row span {
        display: block;
        font-size: 13px;
        color: #0f172a;
    }

    .sd-request-row small {
        display: block;
        color: #64748b;
        margin-top: 4px;
        font-size: 12px;
    }

    .sd-request-main {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sd-request-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: grid !important;
        place-items: center;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a !important;
        font-weight: 800;
    }

    .sd-request-row a {
        color: #334155;
        font-size: 24px;
        text-decoration: none;
    }

    .sd-side-stack {
        display: grid;
        gap: 12px;
        align-content: start;
    }

    .sd-side-title {
        margin: 0 0 18px;
        font-size: 16px;
        font-weight: 800;
    }

    .sd-account-status {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 18px;
        border-radius: 12px;
        background: rgba(24, 199, 167, 0.08);
        border: 1px solid rgba(24, 199, 167, 0.16);
    }

    .sd-account-status > div:first-child {
        font-size: 30px;
    }

    .sd-account-status strong {
        color: #047857;
        font-size: 14px;
    }

    .sd-account-status p {
        margin: 5px 0 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.5;
    }

    .sd-activity-list {
        display: grid;
        gap: 14px;
    }

    .sd-activity-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .sd-activity-item span {
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: rgba(24, 199, 167, 0.12);
        color: #047857;
        font-size: 12px;
        flex-shrink: 0;
    }

    .sd-activity-item strong {
        display: block;
        font-size: 13px;
        color: #0f172a;
        margin-bottom: 3px;
    }

    .sd-activity-item small {
        color: #64748b;
        font-size: 12px;
    }

    .sd-side-link {
        display: inline-flex;
        margin-top: 18px;
        color: #008f7a;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .sd-help-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .sd-help-panel h2 {
        margin: 0 0 8px;
        font-size: 16px;
    }

    .sd-help-panel p {
        margin: 0 0 14px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .sd-help-panel a {
        display: inline-flex;
        height: 36px;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid rgba(0, 143, 122, 0.25);
        color: #008f7a;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-help-illustration {
        font-size: 56px;
        opacity: 0.45;
    }

    .sd-subscription-section {
        margin-top: 20px;
    }

    .sd-subscription-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 12px;
    }

    .sd-subscription-card {
        padding: 14px;
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-subscription-logo {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #18c7a7, #6366f1);
        color: #ffffff;
        font-weight: 900;
    }

    .sd-subscription-card strong {
        display: block;
        font-size: 13px;
        margin-bottom: 4px;
        color: #0f172a;
    }

    .sd-subscription-card small,
    .sd-subscription-card p {
        display: block;
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .sd-subscription-card p {
        margin: 10px 0;
    }

    .sd-empty {
        padding: 26px;
        text-align: center;
        color: #64748b;
    }

    .sd-empty strong {
        display: block;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .sd-empty a {
        display: inline-flex;
        margin-top: 12px;
        color: #008f7a;
        font-weight: 700;
        text-decoration: none;
    }

    .sd-muted-text {
        color: #64748b;
        font-size: 13px;
    }

    @media (max-width: 1280px) {
        .sd-metrics-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .sd-overview-grid {
            grid-template-columns: 1fr;
        }

        .sd-subscription-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 720px) {
        .sd-metrics-grid,
        .sd-subscription-row {
            grid-template-columns: 1fr;
        }

        .sd-request-head {
            display: none;
        }

        .sd-request-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>

@endsection