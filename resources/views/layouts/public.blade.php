<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'StackEase' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400 text-slate-950 font-black">
                        S
                    </span>
                    <span class="text-xl font-bold tracking-tight">
                        Stack<span class="font-medium text-emerald-300">Ease</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-8 text-sm font-medium text-slate-300 md:flex">
                    <a href="{{ route('services') }}" class="hover:text-white">Services</a>
                    <a href="{{ route('deals') }}" class="hover:text-white">Deals</a>
                    <a href="{{ route('managed-subscriptions') }}" class="hover:text-white">Managed Subscriptions</a>
                    <a href="{{ route('concierge') }}" class="hover:text-white">Concierge Request</a>
                </nav>

                <div class="hidden items-center gap-3 md:flex">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-white/15 px-5 py-2 text-sm font-semibold text-white hover:bg-white/10">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="rounded-full bg-emerald-400 px-5 py-2 text-sm font-bold text-slate-950 hover:bg-emerald-300">
                            Get Started
                        </a>
                    @endauth
                </div>

                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 text-white md:hidden"
                    onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                    aria-label="Open menu"
                >
                    ☰
                </button>
            </div>

            <div id="mobileMenu" class="hidden border-t border-white/10 px-6 py-4 md:hidden">
                <nav class="flex flex-col gap-4 text-sm font-medium text-slate-300">
                    <a href="{{ route('services') }}" class="hover:text-white">Services</a>
                    <a href="{{ route('deals') }}" class="hover:text-white">Deals</a>
                    <a href="{{ route('managed-subscriptions') }}" class="hover:text-white">Managed Subscriptions</a>
                    <a href="{{ route('concierge') }}" class="hover:text-white">Concierge Request</a>

                    <div class="mt-3 border-t border-white/10 pt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block rounded-full border border-white/15 px-5 py-3 text-center text-sm font-semibold text-white">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block py-2 text-slate-300">Login</a>
                            <a href="{{ route('register') }}" class="mt-2 block rounded-full bg-emerald-400 px-5 py-3 text-center text-sm font-bold text-slate-950">
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

        <footer class="border-t border-white/10 bg-slate-950">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12 lg:grid-cols-4 lg:px-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400 text-slate-950 font-black">
                            S
                        </span>
                        <span class="text-xl font-bold">
                            Stack<span class="font-medium text-emerald-300">Ease</span>
                        </span>
                    </div>
                    <p class="mt-4 max-w-xl text-sm leading-6 text-slate-400">
                        StackEase helps Nigerian businesses, creators, agencies, and teams request, pay for, set up, and manage approved digital tool stacks with guided support.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-white">Company</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('services') }}" class="hover:text-white">Services</a></li>
                        <li><a href="{{ route('deals') }}" class="hover:text-white">Deals</a></li>
                        <li><a href="{{ route('concierge') }}" class="hover:text-white">Concierge Request</a></li>
                        <li><a href="{{ route('managed-subscriptions') }}" class="hover:text-white">Managed Subscriptions</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-white">Policies</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('policies.terms') }}" class="hover:text-white">Terms of Use</a></li>
                        <li><a href="{{ route('policies.privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('policies.refund') }}" class="hover:text-white">Refund Policy</a></li>
                        <li><a href="{{ route('policies.subscription') }}" class="hover:text-white">Subscription Policy</a></li>
                        <li><a href="{{ route('policies.acceptable-use') }}" class="hover:text-white">Acceptable Use Policy</a></li>
                        <li><a href="{{ route('policies.disclaimer') }}" class="hover:text-white">Disclaimer</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 px-6 py-6">
                <p class="mx-auto max-w-7xl text-sm text-slate-500">
                    © {{ date('Y') }} StackEase. Digital tool stacks, simplified.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>