@extends('layouts.dashboard')

@section('content')

<div class="sd-page-title">
    <h1>Payment Proofs</h1>
    <p>Upload and track manual bank transfer proofs for your StackEase invoices.</p>
</div>

<section class="sd-card sd-card-pad">
    <div class="sd-section-title">
        <h2>Manual Payment Proofs</h2>
        <a href="{{ route('dashboard.invoices') }}">View invoices →</a>
    </div>

    <div class="sd-proof-panel">
        <div class="sd-proof-icon">⇪</div>

        <div>
            <h3>Manual payment proof upload is coming next</h3>
            <p>
                This page is reserved for users who pay invoices by bank transfer.
                Once the manual payment flow is activated, users will be able to upload proof of payment here,
                and StackEase finance admins will verify it from the admin dashboard.
            </p>

            <a href="{{ route('dashboard.invoices') }}">Go to My Invoices</a>
        </div>
    </div>
</section>

<style>
    .sd-proof-panel {
        min-height: 340px;
        display: grid;
        place-items: center;
        text-align: center;
        padding: 40px 20px;
        border-radius: 18px;
        background:
            radial-gradient(circle at top, rgba(24, 199, 167, 0.12), transparent 38%),
            #f8fafc;
        border: 1px dashed rgba(15, 23, 42, 0.14);
    }

    .sd-proof-icon {
        width: 72px;
        height: 72px;
        display: grid;
        place-items: center;
        margin: 0 auto 18px;
        border-radius: 22px;
        background: rgba(24, 199, 167, 0.14);
        color: #008f7a;
        font-size: 30px;
        font-weight: 900;
    }

    .sd-proof-panel h3 {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
        font-weight: 850;
        letter-spacing: -0.04em;
    }

    .sd-proof-panel p {
        max-width: 620px;
        margin: 12px auto 22px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .sd-proof-panel a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 40px;
        padding: 0 18px;
        border-radius: 999px;
        background: #18c7a7;
        color: #020617;
        font-size: 13px;
        font-weight: 850;
        text-decoration: none;
    }
</style>

@endsection