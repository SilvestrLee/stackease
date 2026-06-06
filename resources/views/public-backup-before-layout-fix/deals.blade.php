<x-layouts.public title="Deals | StackEase">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    StackEase Deals
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    Useful digital tool deals for businesses and teams.
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    Discover practical deals for design, productivity, collaboration, cloud, AI, and security tools. StackEase helps you review availability, request support, and manage setup safely.
                </p>
            </div>
        </div>
    </section>

    @if ($featuredDeals->count())
        <section class="border-y se-border se-surface">
            <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
                <div class="mb-10">
                    <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                        Featured Deals
                    </p>
                    <h2 class="mt-3 text-3xl font-black se-text-main">
                        Highlighted offers worth reviewing
                    </h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($featuredDeals as $deal)
                        <article class="rounded-3xl border se-border se-surface-strong p-7">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                                        {{ $deal->category?->name ?? 'Digital Tool' }}
                                    </p>

                                    <h2 class="mt-4 text-xl font-black se-text-main">
                                        {{ $deal->title }}
                                    </h2>
                                </div>

                                @if ($deal->badge)
                                    <span class="rounded-full border se-border px-3 py-1 text-xs font-bold se-text-soft">
                                        {{ $deal->badge }}
                                    </span>
                                @endif
                            </div>

                            <p class="mt-5 leading-7 se-text-soft">
                                {{ $deal->short_description ?? Str::limit(strip_tags($deal->description), 130) }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-3 text-sm se-text-soft">
                                @if ($deal->provider)
                                    <span>{{ $deal->provider->name }}</span>
                                @endif

                                @if ($deal->discount_percent)
                                    <span>{{ $deal->discount_percent }}% off</span>
                                @endif

                                @if ($deal->expires_at)
                                    <span>Expires {{ $deal->expires_at->format('M d, Y') }}</span>
                                @endif
                            </div>

                            <a href="{{ route('deals.show', $deal->slug) }}" class="mt-7 inline-flex text-sm font-bold" style="color: var(--accent);">
                                View deal →
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="mb-10">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Available Deals
                </p>
                <h2 class="mt-3 text-3xl font-black se-text-main">
                    Browse current software offers
                </h2>
            </div>

            @if ($deals->count())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($deals as $deal)
                        <article class="rounded-3xl border se-border se-surface-strong p-7">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                                        {{ $deal->category?->name ?? 'Digital Tool' }}
                                    </p>

                                    <h2 class="mt-4 text-xl font-black se-text-main">
                                        {{ $deal->title }}
                                    </h2>
                                </div>

                                <span class="rounded-full border se-border px-3 py-1 text-xs font-bold se-text-soft">
                                    {{ $deal->provider?->name ?? 'Provider' }}
                                </span>
                            </div>

                            <p class="mt-5 leading-7 se-text-soft">
                                {{ $deal->short_description ?? Str::limit(strip_tags($deal->description), 130) }}
                            </p>

                            <div class="mt-6 grid gap-2 text-sm se-text-soft">
                                @if ($deal->regular_price || $deal->deal_price)
                                    <p>
                                        @if ($deal->regular_price)
                                            Regular: ${{ number_format($deal->regular_price, 2) }}
                                        @endif

                                        @if ($deal->deal_price)
                                            <span class="font-bold" style="color: var(--accent);">
                                                Deal: ${{ number_format($deal->deal_price, 2) }}
                                            </span>
                                        @endif
                                    </p>
                                @endif

                                @if ($deal->expires_at)
                                    <p>Expires: {{ $deal->expires_at->format('M d, Y') }}</p>
                                @endif
                            </div>

                            <a href="{{ route('deals.show', $deal->slug) }}" class="mt-7 inline-flex text-sm font-bold" style="color: var(--accent);">
                                View deal →
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $deals->links() }}
                </div>
            @else
                <div class="rounded-3xl border se-border se-surface-strong p-8 text-center">
                    <h3 class="text-2xl font-black se-text-main">
                        No published deals yet.
                    </h3>

                    <p class="mx-auto mt-3 max-w-2xl se-text-muted">
                        Deals added from the admin dashboard will appear here once they are published and active.
                    </p>

                    <a href="{{ route('concierge') }}" class="mt-7 inline-flex rounded-full px-7 py-4 text-base font-bold se-accent">
                        Request Subscription Help
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="rounded-[2rem] border se-border se-surface-strong px-8 py-14 text-center lg:px-16">
            <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                Important Note
            </p>

            <h2 class="mx-auto mt-4 max-w-3xl text-3xl font-black tracking-tight se-text-main sm:text-5xl">
                Deals are not automatic approvals.
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-lg se-text-muted">
                StackEase may review tool requests before confirming availability, pricing, setup path, and support eligibility. Restricted or risky requests may be declined.
            </p>

            <div class="mt-8">
                <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                    Submit a Request
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>