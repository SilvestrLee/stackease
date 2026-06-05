<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="se-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'StackEase - Digital Tool Stacks. Simplified.' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="se-body">
    <header class="se-header" id="seHeader">
        <div class="se-container se-header__inner">
            <a href="{{ route('home') }}" class="se-logo" aria-label="StackEase">
                <span class="se-logo__mark">S</span>
                <span class="se-logo__text">StackEase</span>
            </a>

            <nav class="se-nav" aria-label="Main navigation">
                <a href="{{ route('services') }}">Services</a>
                <a href="#how-it-works">How It Works</a>
                <a href="{{ url('/pricing') }}">Pricing</a>
                <a href="{{ url('/resources') }}">Resources</a>
                <a href="{{ url('/about-us') }}">About Us</a>
            </nav>

            <div class="se-header__actions">
                <button class="se-theme-toggle" type="button" id="seThemeToggle" aria-label="Toggle theme">
                    <span class="se-theme-toggle__icon" id="seThemeIcon">🌙</span>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" class="se-login-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="se-login-link">Log in</a>
                @endauth

                <a href="{{ route('concierge') }}" class="se-btn se-btn--primary">Request Setup Help</a>

                <button class="se-menu-toggle" type="button" id="seMenuToggle" aria-label="Open menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <div class="se-mobile-menu" id="seMobileMenu">
            <a href="{{ route('services') }}">Services</a>
            <a href="#how-it-works">How It Works</a>
            <a href="{{ url('/pricing') }}">Pricing</a>
            <a href="{{ url('/resources') }}">Resources</a>
            <a href="{{ url('/about-us') }}">About Us</a>

            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
            @endauth

            <a href="{{ route('concierge') }}">Request Setup Help</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="se-footer">
        <div class="se-container se-footer__grid">
            <div class="se-footer__brand">
                <a href="{{ route('home') }}" class="se-logo se-logo--footer" aria-label="StackEase">
                    <span class="se-logo__mark">S</span>
                    <span class="se-logo__text">StackEase</span>
                </a>

                <p>
                    We help Nigerian businesses, creators, agencies, and teams access and manage approved digital tools with ease.
                </p>
            </div>

            <div>
                <h4>Company</h4>
                <a href="{{ url('/about-us') }}">About Us</a>
                <a href="#how-it-works">How It Works</a>
                <a href="{{ url('/pricing') }}">Pricing</a>
                <a href="{{ url('/blog') }}">Blog</a>
                <a href="{{ url('/contact-us') }}">Contact Us</a>
            </div>

            <div>
                <h4>Services</h4>
                <a href="{{ route('services') }}">All Services</a>
                <a href="{{ route('services') }}">Canva Support</a>
                <a href="{{ route('services') }}">Google Workspace</a>
                <a href="{{ route('services') }}">Notion Setup</a>
                <a href="{{ route('services') }}">Microsoft 365</a>
                <a href="{{ route('services') }}">VPN Solutions</a>
            </div>

            <div>
                <h4>Resources</h4>
                <a href="{{ url('/help-center') }}">Help Center</a>
                <a href="{{ url('/guides') }}">Guides</a>
                <a href="{{ url('/faq') }}">FAQ</a>
                <a href="{{ url('/status') }}">Status</a>
                <a href="{{ url('/request-support') }}">Request Support</a>
            </div>

            <div>
                <h4>Legal</h4>
                <a href="{{ url('/terms-of-use') }}">Terms of Use</a>
                <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                <a href="{{ url('/refund-policy') }}">Refund Policy</a>
                <a href="{{ url('/subscription-policy') }}">Subscription Policy</a>
                <a href="{{ url('/acceptable-use-policy') }}">Acceptable Use Policy</a>
            </div>
        </div>

        <div class="se-container se-footer__bottom">
            <p>© 2025 StackEase. All rights reserved.</p>
            <p>Made with ❤️ in Nigeria</p>
        </div>
    </footer>
</body>
</html>