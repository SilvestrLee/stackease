@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>Support Tickets</h1>
    <p>Track support conversations related to setup, access, payments, and renewals.</p>
</div>

<section class="sd-card sd-card-pad">
    <div class="sd-section-title">
        <h2>Ticket Records</h2>
        <a href="{{ route('concierge') }}">Need a new setup? →</a>
    </div>

    <div class="sd-ticket-list">
        @forelse ($tickets as $ticket)
            <article class="sd-ticket-record">
                <div class="sd-ticket-main">
                    <div class="sd-ticket-icon">
                        {{ strtoupper(substr($ticket->subject ?? 'T', 0, 1)) }}
                    </div>

                    <div>
                        <h3>{{ $ticket->subject ?? 'Support Ticket' }}</h3>
                        <p>{{ $ticket->ticket_reference ?? 'TIC-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="sd-ticket-grid">
                    <div>
                        <span>Category</span>
                        <strong>{{ str_replace('_', ' ', Str::title($ticket->category ?? 'General')) }}</strong>
                    </div>

                    <div>
                        <span>Priority</span>
                        <strong>{{ Str::title($ticket->priority ?? 'Normal') }}</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong>{{ str_replace('_', ' ', Str::title($ticket->status ?? 'Open')) }}</strong>
                    </div>

                    <div>
                        <span>Related Subscription</span>
                        <strong>{{ $ticket->subscription?->provider?->name ?? $ticket->subscription?->name ?? 'Not linked' }}</strong>
                    </div>

                    <div>
                        <span>Related Request</span>
                        <strong>{{ $ticket->conciergeRequest?->request_reference ?? 'Not linked' }}</strong>
                    </div>

                    <div>
                        <span>Last Updated</span>
                        <strong>{{ $ticket->updated_at?->format('M d, Y h:i A') }}</strong>
                    </div>
                </div>

                @if (! empty($ticket->message))
                    <div class="sd-ticket-message">
                        <span>Your Message</span>
                        <p>{{ $ticket->message }}</p>
                    </div>
                @elseif (! empty($ticket->description))
                    <div class="sd-ticket-message">
                        <span>Your Message</span>
                        <p>{{ $ticket->description }}</p>
                    </div>
                @endif

                <div class="sd-ticket-side">
                    <span class="sd-status sd-status--{{ $ticket->status }}">
                        {{ str_replace('_', ' ', Str::title($ticket->status ?? 'Open')) }}
                    </span>

                    <small>
                        Created {{ $ticket->created_at?->format('M d, Y') }}
                    </small>

                    <button type="button" disabled>
                        Reply Coming Soon
                    </button>
                </div>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No support tickets yet</strong>
                <p>Your support tickets will appear here when you need help with setup, payments, access, or renewals.</p>
                <a href="{{ route('concierge') }}">Start a request</a>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-ticket-list {
        display: grid;
        gap: 16px;
    }

    .sd-ticket-record {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 180px;
        gap: 24px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-ticket-main {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .sd-ticket-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a;
        font-weight: 900;
    }

    .sd-ticket-record h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 850;
        letter-spacing: -0.03em;
        color: #0f172a;
    }

    .sd-ticket-record p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .sd-ticket-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .sd-ticket-grid span,
    .sd-ticket-message span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-ticket-grid strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 750;
    }

    .sd-ticket-message {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .sd-ticket-message p {
        margin: 0;
        color: #334155;
        font-size: 13px;
        line-height: 1.6;
    }

    .sd-ticket-side {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 14px;
        padding: 18px;
        border-radius: 16px;
        background: #f8fafc;
    }

    .sd-ticket-side small {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-ticket-side button {
        height: 36px;
        padding: 0 14px;
        border-radius: 999px;
        border: 0;
        background: #cbd5e1;
        color: #475569;
        font-size: 12px;
        font-weight: 800;
        cursor: not-allowed;
    }

    .sd-status--open,
    .sd-status--pending,
    .sd-status--in_progress {
        background: rgba(245, 158, 11, 0.14);
        color: #b45309;
    }

    .sd-status--resolved,
    .sd-status--closed {
        background: rgba(34, 197, 94, 0.12);
        color: #047857;
    }

    .sd-status--cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    @media (max-width: 900px) {
        .sd-ticket-record {
            grid-template-columns: 1fr;
        }

        .sd-ticket-grid {
            grid-template-columns: 1fr;
        }

        .sd-ticket-side {
            align-items: flex-start;
        }
    }
</style>

@endsection