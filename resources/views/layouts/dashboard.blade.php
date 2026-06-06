<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard | StackEase' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sd-bg: #f8fafc;
            --sd-sidebar: #020b1f;
            --sd-sidebar-soft: rgba(20, 199, 167, 0.08);
            --sd-accent: #18c7a7;
            --sd-text: #07111f;
            --sd-muted: #64748b;
            --sd-border: rgba(15, 23, 42, 0.1);
            --sd-card: #ffffff;
            --sd-radius: 22px;
        }

        body {
            margin: 0;
            background: var(--sd-bg);
            color: var(--sd-text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .sd-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 268px 1fr;
            background: var(--sd-bg);
        }

        .sd-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 28px 22px;
            background:
                radial-gradient(circle at top left, rgba(24, 199, 167, 0.2), transparent 32%),
                linear-gradient(180deg, #061228 0%, #020b1f 100%);
            color: #ffffff;
            overflow-y: auto;
        }

        .sd-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
            margin-bottom: 48px;
        }

        .sd-brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            background: var(--sd-accent);
            color: #020617;
            font-weight: 900;
        }

        .sd-brand-text {
            font-size: 22px;
            font-weight: 850;
            letter-spacing: -0.04em;
        }

        .sd-nav {
            display: grid;
            gap: 10px;
        }

        .sd-nav a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 16px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
            font-size: 15px;
            font-weight: 650;
            transition: background 0.18s ease, color 0.18s ease;
        }

        .sd-nav a:hover,
        .sd-nav a.is-active {
            background: linear-gradient(90deg, rgba(24, 199, 167, 0.26), rgba(24, 199, 167, 0.06));
            color: #ffffff;
        }

        .sd-nav-icon {
            width: 22px;
            display: inline-grid;
            place-items: center;
            font-size: 16px;
        }

        .sd-help-card {
            margin-top: 64px;
            padding: 20px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.035);
        }

        .sd-help-card strong {
            display: block;
            color: var(--sd-accent);
            margin-top: 3px;
        }

        .sd-help-card p {
            color: rgba(255, 255, 255, 0.68);
            font-size: 13px;
            line-height: 1.6;
            margin: 14px 0 0;
        }

        .sd-main {
            min-width: 0;
        }

        .sd-topbar {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 0 32px;
            background: rgba(255, 255, 255, 0.78);
            border-bottom: 1px solid var(--sd-border);
            backdrop-filter: blur(18px);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .sd-search {
            width: min(100%, 280px);
            height: 42px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 14px;
            border: 1px solid var(--sd-border);
            border-radius: 8px;
            background: #ffffff;
            color: var(--sd-muted);
            font-size: 13px;
        }

        .sd-search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--sd-text);
            font-size: 13px;
        }

        .sd-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sd-bell {
            position: relative;
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            color: #475569;
        }

        .sd-bell span {
            position: absolute;
            top: 3px;
            right: 3px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: var(--sd-accent);
            color: #020617;
            font-size: 11px;
            font-weight: 800;
        }

        .sd-user-name {
            text-align: right;
        }

        .sd-user-name strong {
            display: block;
            font-size: 15px;
            line-height: 1.1;
        }

        .sd-user-name small {
            color: var(--sd-muted);
            font-size: 12px;
        }

        .sd-avatar {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #18c7a7, #60a5fa);
            color: #020617;
            font-weight: 900;
            border: 3px solid #ffffff;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
        }

        .sd-content {
            padding: 32px;
        }

        .sd-page-title {
            margin-bottom: 26px;
        }

        .sd-page-title h1 {
            margin: 0;
            font-size: 26px;
            line-height: 1.2;
            letter-spacing: -0.04em;
            font-weight: 850;
        }

        .sd-page-title p {
            margin: 8px 0 0;
            color: var(--sd-muted);
            font-size: 15px;
        }

        .sd-card {
            background: var(--sd-card);
            border: 1px solid var(--sd-border);
            border-radius: var(--sd-radius);
            box-shadow: 0 16px 50px rgba(15, 23, 42, 0.045);
        }

        .sd-card-pad {
            padding: 22px;
        }

        .sd-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .sd-section-title h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .sd-section-title a {
            color: #008f7a;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .sd-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 750;
            background: rgba(24, 199, 167, 0.12);
            color: #047857;
        }

        @media (max-width: 1180px) {
            .sd-shell {
                grid-template-columns: 1fr;
            }

            .sd-sidebar {
                position: relative;
                height: auto;
            }

            .sd-nav {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sd-help-card {
                margin-top: 24px;
            }
        }

        @media (max-width: 720px) {
            .sd-topbar {
                height: auto;
                padding: 18px;
                align-items: flex-start;
                flex-direction: column;
            }

            .sd-search {
                width: 100%;
            }

            .sd-content {
                padding: 20px;
            }

            .sd-nav {
                grid-template-columns: 1fr;
            }

            .sd-user {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>
    @php
        $user = auth()->user();
        $displayName = $user?->name ?? 'User';
        $initial = strtoupper(substr($displayName, 0, 1));
    @endphp

    <div class="sd-shell">
        <aside class="sd-sidebar">
            <a href="{{ route('dashboard') }}" class="sd-brand">
                <span class="sd-brand-mark">S</span>
                <span class="sd-brand-text">StackEase</span>
            </a>

            <nav class="sd-nav" aria-label="Dashboard navigation">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">⌂</span>
                    <span>Overview</span>
                </a>

                <a href="{{ route('dashboard.requests') }}" class="{{ request()->routeIs('dashboard.requests') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">▣</span>
                    <span>My Requests</span>
                </a>

                <a href="{{ route('dashboard.invoices') }}" class="{{ request()->routeIs('dashboard.invoices*') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">▤</span>
                    <span>My Invoices</span>
                </a>

                <a href="{{ route('dashboard.subscriptions') }}" class="{{ request()->routeIs('dashboard.subscriptions') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">◇</span>
                    <span>My Subscriptions</span>
                </a>

                <a href="{{ route('dashboard.payment-proofs') }}" class="{{ request()->routeIs('dashboard.payment-proofs') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">⇪</span>
                    <span>Payment Proofs</span>
                </a>

                <a href="{{ route('dashboard.tickets') }}" class="{{ request()->routeIs('dashboard.tickets') ? 'is-active' : '' }}">
                    <span class="sd-nav-icon">▱</span>
                    <span>Support Tickets</span>
                </a>

                <a href="{{ url('/profile') }}">
                    <span class="sd-nav-icon">⚙</span>
                    <span>Account Settings</span>
                </a>
            </nav>

            <div class="sd-help-card">
                <small>Need help?</small>
                <strong>Contact Support</strong>
                <p>We typically reply within a few minutes during active support hours.</p>
            </div>
        </aside>

        <main class="sd-main">
            <header class="sd-topbar">
                <form class="sd-search" action="#" method="GET">
                    <span>⌕</span>
                    <input type="search" placeholder="Search anything..." aria-label="Search">
                </form>

                <div class="sd-user">
                    <div class="sd-bell">
                        🔔
                        <span>3</span>
                    </div>

                    <div class="sd-user-name">
                        <strong>Hi, {{ explode(' ', $displayName)[0] }}</strong>
                        <small>Business User</small>
                    </div>

                    <div class="sd-avatar">
                        {{ $initial }}
                    </div>
                </div>
            </header>

            <section class="sd-content">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>