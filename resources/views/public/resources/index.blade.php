<x-layouts.public title="Resources | StackEase">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Resources
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    Guides for managing your digital tool stack better.
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    Learn how to choose, pay for, set up, and manage business tools like Canva Teams, Google Workspace, Notion, Slack, VPNs, Microsoft 365, and more.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    [
                        'title' => 'How Nigerian Businesses Can Manage Global SaaS Tools Without Payment Stress',
                        'slug' => 'manage-global-saas-tools-without-payment-stress',
                        'excerpt' => 'A practical guide to handling payment, setup, FX changes, and renewals for global digital tools.',
                    ],
                    [
                        'title' => 'Canva Teams for Small Businesses: What to Know Before You Subscribe',
                        'slug' => 'canva-teams-for-small-businesses',
                        'excerpt' => 'Understand seats, team access, design workflows, and setup considerations before requesting Canva Teams support.',
                    ],
                    [
                        'title' => 'Why FX Changes Affect Digital Subscription Pricing in Nigeria',
                        'slug' => 'why-fx-changes-affect-digital-subscription-pricing',
                        'excerpt' => 'A simple explanation of exchange rates, buffers, invoice expiry, and why clear pricing matters.',
                    ],
                ] as $post)
                    <article class="rounded-3xl border se-border se-surface-strong p-7">
                        <p class="text-xs font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                            Guide
                        </p>

                        <h2 class="mt-4 text-xl font-black leading-8 se-text-main">
                            {{ $post['title'] }}
                        </h2>

                        <p class="mt-4 se-text-soft">
                            {{ $post['excerpt'] }}
                        </p>

                        <a href="{{ route('resources.show', $post['slug']) }}" class="mt-7 inline-flex text-sm font-bold" style="color: var(--accent);">
                            Read guide →
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>