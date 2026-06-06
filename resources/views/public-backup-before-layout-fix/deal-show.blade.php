<x-layouts.public title="{{ $deal->title }} | StackEase Deals">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    {{ $deal->category?->name ?? 'StackEase Deal' }}
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    {{ $deal->title }}
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    {{ $deal->short_description ?? 'Review this digital tool offer and request StackEase support if you need payment, setup, renewal, or onboarding assistance.' }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($deal->provider)
                        <span class="rounded-full border se-border px-4 py-2 text-sm font-bold se-text-soft">
                            Provider: {{ $deal->provider->name }}
                        </span>
                    @endif

                    @if ($deal->badge)
                        <span class="rounded-full border se-border px-4 py-2 text-sm font-bold se-text-soft">
                            {{ $deal->badge }}
                        </span>
                    @endif

                    @if ($deal->discount_percent)
                        <span class="rounded-full border se-border px-4 py-2 text-sm font-bold se-text-soft">
                            {{ $deal->discount_percent }}% off
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 lg:grid-cols-[1fr_360px] lg:px-8">
            <article class="rounded-3xl border se-border se-surface-strong p-8">
                <h2 class="text-2xl font-black se-text-main">
                    Deal Details
                </h2>

                <div class="mt-6 leading-8 se-text-soft">
                    {!! nl2br(e($deal->description ?? $deal->short_description ?? 'No additional details provided yet.')) !!}
                </div>

                <div class="mt-8 rounded-2xl border se-border p-5">
                    <h3 class="text-lg font-black se-text-main">
                        StackEase Review Notice
                    </h3>

                    <p class="mt-3 leading-7 se-text-muted">
                        Deals listed on StackEase may still require review before support, setup, payment assistance, or provisioning can be confirmed. Provider pricing, eligibility, availability, and rules may change.
                    </p>
                </div>
            </article>

            <aside class="rounded-3xl border se-border se-surface-strong p-8">
                <p class="text-sm font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                    Offer Summary
                </p>

                <div class="mt-6 space-y-4 text-sm se-text-soft">
                    @if ($deal->regular_price)
                        <p>
                            <span class="font-bold se-text-main">Regular Price:</span>
                            ${{ number_format($deal->regular_price, 2) }}
                        </p>
                    @endif

                    @if ($deal->deal_price)
                        <p>
                            <span class="font-bold se-text-main">Deal Price:</span>
                            ${{ number_format($deal->deal_price, 2) }}
                        </p>
                    @endif

                    @if ($deal->discount_percent)
                        <p>
                            <span class="font-bold se-text-main">Discount:</span>
                            {{ $deal->discount_percent }}%
                        </p>
                    @endif

                    @if ($deal->expires_at)
                        <p>
                            <span class="font-bold se-text-main">Expires:</span>
                            {{ $deal->expires_at->format('M d, Y') }}
                        </p>
                    @endif

                    <p>
                        <span class="font-bold se-text-main">Status:</span>
                        {{ ucfirst($deal->status) }}
                    </p>
                </div>

                <div class="mt-8 grid gap-3">
                    <a href="{{ route('concierge') }}?deal={{ $deal->slug }}"
                       class="se-accent inline-flex justify-center rounded-full px-7 py-4 text-base font-bold">
                        Request Help With This Deal
                    </a>

                    @if ($deal->deal_url)
                        <a href="{{ $deal->deal_url }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex justify-center rounded-full border se-border px-7 py-4 text-base font-bold se-text-main">
                            View Official Deal
                        </a>
                    @endif

                    <a href="{{ route('deals') }}"
                       class="inline-flex justify-center text-sm font-bold"
                       style="color: var(--accent);">
                        ← Back to Deals
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>