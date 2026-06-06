@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>My Requests</h1>
    <p>Track your StackEase concierge requests from submission to completion.</p>
</div>

<section class="sd-card sd-card-pad">
    <div class="sd-section-title">
        <h2>Request Records</h2>
        <a href="{{ route('concierge') }}">New concierge request →</a>
    </div>

    <div class="sd-request-list">
        @forelse ($requests as $request)
            <article class="sd-request-record">
                <div class="sd-request-record-main">
                    <div class="sd-request-record-icon">
                        {{ strtoupper(substr($request->provider?->name ?? $request->service_name ?? 'S', 0, 1)) }}
                    </div>

                    <div>
                        <h3>{{ $request->service_name ?? $request->provider?->name ?? 'Concierge Request' }}</h3>
                        <p>{{ $request->request_reference ?? 'REQ-' . str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="sd-request-record-grid">
                    <div>
                        <span>Provider</span>
                        <strong>{{ $request->provider?->name ?? 'Not assigned' }}</strong>
                    </div>

                    <div>
                        <span>Request Type</span>
                        <strong>{{ str_replace('_', ' ', Str::title($request->request_type ?? 'General Request')) }}</strong>
                    </div>

                    <div>
                        <span>Seats</span>
                        <strong>{{ $request->seat_count ?? 1 }}</strong>
                    </div>

                    <div>
                        <span>Batch Window</span>
                        <strong>{{ $request->batchWindow?->name ?? 'Not assigned' }}</strong>
                    </div>

                    <div>
                        <span>Submitted</span>
                        <strong>{{ $request->created_at?->format('M d, Y') }}</strong>
                    </div>

                    <div>
                        <span>Last Updated</span>
                        <strong>{{ $request->updated_at?->format('M d, Y') }}</strong>
                    </div>
                </div>

                @if (! empty($request->user_notes))
                    <div class="sd-request-note">
                        <span>Your Note</span>
                        <p>{{ $request->user_notes }}</p>
                    </div>
                @endif

                @if (! empty($request->admin_notes))
                    <div class="sd-request-note sd-request-note--admin">
                        <span>StackEase Note</span>
                        <p>{{ $request->admin_notes }}</p>
                    </div>
                @endif

                <div class="sd-request-record-side">
                    <span class="sd-status">
                        {{ str_replace('_', ' ', Str::title($request->status)) }}
                    </span>

                    @if ($request->invoices?->count())
                        <a href="{{ route('dashboard.invoices.show', $request->invoices->first()) }}">
                            View Invoice
                        </a>
                    @else
                        <small>No invoice yet</small>
                    @endif
                </div>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No requests yet</strong>
                <p>Submit your first concierge request and StackEase will review it.</p>
                <a href="{{ route('concierge') }}">Create request</a>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-request-list {
        display: grid;
        gap: 16px;
    }

    .sd-request-record {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 180px;
        gap: 24px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-request-record-main {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .sd-request-record-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a;
        font-weight: 900;
    }

    .sd-request-record h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 850;
        letter-spacing: -0.03em;
        color: #0f172a;
    }

    .sd-request-record p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .sd-request-record-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-request-record-grid span,
    .sd-request-note span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-request-record-grid strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 750;
    }

    .sd-request-note {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-request-note--admin {
        background: rgba(24, 199, 167, 0.07);
        border-color: rgba(24, 199, 167, 0.18);
    }

    .sd-request-note p {
        margin: 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-request-record-side {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 14px;
        padding: 18px;
        border-radius: 16px;
        background: #f8fafc;
    }

    .sd-request-record-side a {
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

    .sd-request-record-side small {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .sd-request-record {
            grid-template-columns: 1fr;
        }

        .sd-request-record-grid {
            grid-template-columns: 1fr;
        }

        .sd-request-record-side {
            align-items: flex-start;
        }
    }
</style>

@endsection