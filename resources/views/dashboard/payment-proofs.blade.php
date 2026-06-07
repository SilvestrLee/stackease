@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>Payment Proofs</h1>
    <p>Upload and track manual bank transfer proofs for your StackEase invoices.</p>
</div>

@if (session('status'))
    <div class="sd-success-alert">
        {{ session('status') }}
    </div>
@endif

<div class="sd-proof-grid">
    <section class="sd-card sd-card-pad">
        <div class="sd-section-title">
            <h2>Upload Payment Proof</h2>
            <a href="{{ route('dashboard.invoices') }}">View invoices →</a>
        </div>

        @if ($invoices->count())
            <form method="POST" action="{{ route('dashboard.payment-proofs.store') }}" enctype="multipart/form-data" class="sd-proof-form">
                @csrf

                <div>
                    <label for="invoice_id">Select Invoice</label>
                    <select name="invoice_id" id="invoice_id" required>
                        <option value="">Choose invoice</option>

                        @foreach ($invoices as $invoice)
                            <option value="{{ $invoice->id }}" @selected(old('invoice_id') == $invoice->id)>
                                {{ $invoice->invoice_reference ?? 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                —
                                ₦{{ number_format((float) ($invoice->total_naira_amount ?? $invoice->amount ?? 0), 2) }}
                            </option>
                        @endforeach
                    </select>

                    @error('invoice_id')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="amount">Amount Paid</label>
                    <input 
                        type="number" 
                        name="amount" 
                        id="amount" 
                        min="1" 
                        step="0.01" 
                        value="{{ old('amount') }}" 
                        placeholder="Enter amount paid"
                        required
                    >

                    @error('amount')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="proof_of_payment">Upload Proof</label>
                    <input 
                        type="file" 
                        name="proof_of_payment" 
                        id="proof_of_payment" 
                        accept=".jpg,.jpeg,.png,.pdf,.webp"
                        required
                    >

                    <p class="sd-form-hint">
                        Accepted formats: JPG, PNG, WEBP, PDF. Maximum size: 5MB.
                    </p>

                    @error('proof_of_payment')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit">
                    Submit Payment Proof
                </button>
            </form>
        @else
            <div class="sd-empty">
                <strong>No unpaid invoices available</strong>
                <p>You currently have no invoice that requires manual payment proof.</p>
                <a href="{{ route('dashboard.invoices') }}">View invoices</a>
            </div>
        @endif
    </section>

    <aside class="sd-card sd-card-pad">
        <div class="sd-proof-info">
            <div class="sd-proof-icon">⇪</div>

            <h3>Manual transfer review</h3>

            <p>
                Uploaded payment proofs are reviewed by StackEase finance/admin.
                Your invoice will only be marked paid after verification.
            </p>

            <ul>
                <li>Upload only clear payment evidence.</li>
                <li>Use the exact invoice amount where possible.</li>
                <li>Late or underpaid invoices may require admin review.</li>
            </ul>
        </div>
    </aside>
</div>

<section class="sd-card sd-card-pad sd-proof-history">
    <div class="sd-section-title">
        <h2>Submitted Proofs</h2>
    </div>

    <div class="sd-proof-list">
        @forelse ($payments as $payment)
            <article class="sd-proof-record">
                <div>
                    <h3>{{ $payment->payment_reference }}</h3>
                    <p>
                        Invoice:
                        {{ $payment->invoice?->invoice_reference ?? 'INV-' . str_pad($payment->invoice_id, 5, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div>
                    <span>Amount</span>
                    <strong>₦{{ number_format((float) $payment->amount, 2) }}</strong>
                </div>

                <div>
                    <span>Status</span>
                    <strong>{{ str_replace('_', ' ', Str::title($payment->status)) }}</strong>
                </div>

                <div>
                    <span>Submitted</span>
                    <strong>{{ $payment->created_at?->format('M d, Y h:i A') }}</strong>
                </div>

                <a href="{{ asset('storage/' . $payment->proof_of_payment_path) }}" target="_blank" rel="noopener">
                    View Proof
                </a>
            </article>
        @empty
            <div class="sd-empty">
                <strong>No payment proof submitted yet</strong>
                <p>Your uploaded bank transfer proofs will appear here.</p>
            </div>
        @endforelse
    </div>
</section>

<style>
    .sd-success-alert {
        margin-bottom: 18px;
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(24, 199, 167, 0.12);
        border: 1px solid rgba(24, 199, 167, 0.22);
        color: #047857;
        font-size: 14px;
        font-weight: 700;
    }

    .sd-proof-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 20px;
    }

    .sd-proof-form {
        display: grid;
        gap: 18px;
    }

    .sd-proof-form label {
        display: block;
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 13px;
        font-weight: 800;
    }

    .sd-proof-form select,
    .sd-proof-form input {
        width: 100%;
        height: 44px;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.12);
        background: #ffffff;
        padding: 0 14px;
        color: #0f172a;
        font-size: 14px;
        outline: none;
    }

    .sd-proof-form input[type="file"] {
        padding: 10px 14px;
        height: auto;
    }

    .sd-proof-form small {
        display: block;
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-form-hint {
        margin: 7px 0 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .sd-proof-form button {
        height: 44px;
        border: 0;
        border-radius: 999px;
        background: #18c7a7;
        color: #020617;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
    }

    .sd-proof-info {
        text-align: left;
    }

    .sd-proof-icon {
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        margin-bottom: 18px;
        border-radius: 20px;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a;
        font-size: 28px;
        font-weight: 900;
    }

    .sd-proof-info h3 {
        margin: 0 0 10px;
        color: #0f172a;
        font-size: 20px;
        font-weight: 850;
        letter-spacing: -0.04em;
    }

    .sd-proof-info p,
    .sd-proof-info li {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .sd-proof-info ul {
        margin: 16px 0 0;
        padding-left: 18px;
    }

    .sd-proof-history {
        margin-top: 20px;
    }

    .sd-proof-list {
        display: grid;
        gap: 14px;
    }

    .sd-proof-record {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) 0.7fr 0.7fr 1fr auto;
        gap: 16px;
        align-items: center;
        padding: 16px;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    .sd-proof-record h3 {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
    }

    .sd-proof-record p {
        margin: 0;
        color: #64748b;
        font-size: 12px;
    }

    .sd-proof-record span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .sd-proof-record strong {
        color: #0f172a;
        font-size: 13px;
        font-weight: 800;
    }

    .sd-proof-record a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        padding: 0 14px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #008f7a;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    @media (max-width: 1100px) {
        .sd-proof-grid {
            grid-template-columns: 1fr;
        }

        .sd-proof-record {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection