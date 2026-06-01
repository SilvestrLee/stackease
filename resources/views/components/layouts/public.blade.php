<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'StackEase' }}</title>

    <script>
        const savedTheme = localStorage.getItem('stackease-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <style>
        :root[data-theme="dark"] {
            --page-bg: #020617;
            --surface: rgba(255, 255, 255, 0.04);
            --surface-strong: rgba(255, 255, 255, 0.07);
            --border: rgba(255, 255, 255, 0.10);
            --text-main: #ffffff;
            --text-muted: #cbd5e1;
            --text-soft: #94a3b8;
            --accent: #34d399;
            --accent-hover: #6ee7b7;
            --accent-text: #020617;
            --header-bg: rgba(2, 6, 23, 0.90);
        }

        :root[data-theme="light"] {
            --page-bg: #f8fafc;
            --surface: rgba(15, 23, 42, 0.04);
            --surface-strong: #ffffff;
            --border: rgba(15, 23, 42, 0.12);
            --text-main: #0f172a;
            --text-muted: #334155;
            --text-soft: #64748b;
            --accent: #10b981;
            --accent-hover: #059669;
            --accent-text: #ffffff;
            --header-bg: rgba(248, 250, 252, 0.92);
        }

        body {
            background: var(--page-bg);
            color: var(--text-main);
        }

        .se-surface {
            background: var(--surface);
        }

        .se-surface-strong {
            background: var(--surface-strong);
        }

        .se-border {
            border-color: var(--border);
        }

        .se-text-main {
            color: var(--text-main);
        }

        .se-text-muted {
            color: var(--text-muted);
        }

        .se-text-soft {
            color: var(--text-soft);
        }

        .se-accent {
            background: var(--accent);
            color: var(--accent-text);
        }

        .se-accent:hover {
            background: var(--accent-hover);
        }

        .se-header {
            background: var(--header-bg);
        }

        .se-link:hover {
            color: var(--text-main);
        }

        .se-hover-surface:hover {
            background: var(--surface);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="se-header sticky top-0 z-50 border-b se-border backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="se-accent flex h-10 w-10 items-center justify-center rounded-2xl font-black">
                        S
                    </span>
                    <span class="se-text-main text-xl font-bold tracking-tight">
                        Stack<span style="color: var(--accent);" class="font-medium">Ease</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-8 text-sm font-medium se-text-muted md:flex">
                    <a href="{{ route('services') }}" class="se-link">Services</a>
                    <a href="{{ route('deals') }}" class="se-link">Deals</a>
                    <a href="{{ route('resources.index') }}" class="se-link">Resources</a>
                    <a href="{{ route('managed-subscriptions') }}" class="se-link">Managed Subscriptions</a>
                    <a href="{{ route('concierge') }}" class="se-link">Concierge Request</a>
                </nav>

                <div class="hidden items-center gap-3 md:flex">
                    <button
                        type="button"
                        onclick="toggleStackEaseTheme()"
                        class="rounded-full border se-border px-4 py-2 text-sm font-semibold se-text-main se-hover-surface"
                    >
                        <span class="theme-toggle-label">Light</span>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border se-border px-5 py-2 text-sm font-semibold se-text-main se-hover-surface">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold se-text-muted se-link">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="se-accent rounded-full px-5 py-2 text-sm font-bold">
                            Get Started
                        </a>
                    @endauth
                </div>

                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border se-border se-text-main md:hidden"
                    onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                    aria-label="Open menu"
                >
                    ☰
                </button>
            </div>

            <div id="mobileMenu" class="hidden border-t se-border px-6 py-4 md:hidden">
                <nav class="flex flex-col gap-4 text-sm font-medium se-text-muted">
                    <a href="{{ route('services') }}" class="se-link">Services</a>
                    <a href="{{ route('deals') }}" class="se-link">Deals</a>
                    <a href="{{ route('resources.index') }}" class="se-link">Resources</a>
                    <a href="{{ route('managed-subscriptions') }}" class="se-link">Managed Subscriptions</a>
                    <a href="{{ route('concierge') }}" class="se-link">Concierge Request</a>

                    <button
                        type="button"
                        onclick="toggleStackEaseTheme()"
                        class="rounded-full border se-border px-5 py-3 text-sm font-semibold se-text-main se-hover-surface"
                    >
                        Switch to <span class="theme-toggle-label">Light</span> Mode
                    </button>

                    <div class="mt-3 border-t se-border pt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block rounded-full border se-border px-5 py-3 text-center text-sm font-semibold se-text-main se-hover-surface">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block py-2 se-text-muted">Login</a>
                            <a href="{{ route('register') }}" class="se-accent mt-2 block rounded-full px-5 py-3 text-center text-sm font-bold">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="border-t se-border">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12 lg:grid-cols-4 lg:px-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="se-accent flex h-10 w-10 items-center justify-center rounded-2xl font-black">
                            S
                        </span>
                        <span class="se-text-main text-xl font-bold">
                            Stack<span style="color: var(--accent);" class="font-medium">Ease</span>
                        </span>
                    </div>

                    <p class="mt-4 max-w-xl text-sm leading-6 se-text-soft">
                        StackEase helps Nigerian businesses, creators, agencies, and teams request, pay for, set up, and manage approved digital tool stacks with guided support.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-bold se-text-main">Company</h3>
                    <ul class="mt-4 space-y-3 text-sm se-text-soft">
                        <li><a href="{{ route('services') }}" class="se-link">Services</a></li>
                        <li><a href="{{ route('deals') }}" class="se-link">Deals</a></li>
                        <li><a href="{{ route('resources.index') }}" class="se-link">Resources</a></li>
                        <li><a href="{{ route('concierge') }}" class="se-link">Concierge Request</a></li>
                        <li><a href="{{ route('managed-subscriptions') }}" class="se-link">Managed Subscriptions</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold se-text-main">Policies</h3>
                    <ul class="mt-4 space-y-3 text-sm se-text-soft">
                        <li><a href="{{ route('policies.terms') }}" class="se-link">Terms of Use</a></li>
                        <li><a href="{{ route('policies.privacy') }}" class="se-link">Privacy Policy</a></li>
                        <li><a href="{{ route('policies.refund') }}" class="se-link">Refund Policy</a></li>
                        <li><a href="{{ route('policies.subscription') }}" class="se-link">Subscription Policy</a></li>
                        <li><a href="{{ route('policies.acceptable-use') }}" class="se-link">Acceptable Use Policy</a></li>
                        <li><a href="{{ route('policies.disclaimer') }}" class="se-link">Disclaimer</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t se-border px-6 py-6">
                <p class="mx-auto max-w-7xl text-sm se-text-soft">
                    © {{ date('Y') }} StackEase. Digital tool stacks, simplified.
                </p>
            </div>
        </footer>
    </div>

    <script>
        function updateThemeToggleLabel() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const nextLabel = currentTheme === 'dark' ? 'Light' : 'Dark';

            document.querySelectorAll('.theme-toggle-label').forEach((label) => {
                label.textContent = nextLabel;
            });
        }

        function toggleStackEaseTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', nextTheme);
            localStorage.setItem('stackease-theme', nextTheme);
            updateThemeToggleLabel();
        }

        updateThemeToggleLabel();
    </script>
</body>
</html>