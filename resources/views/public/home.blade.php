<x-layouts.public title="StackEase | Digital Tool Stacks, Simplified">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.18), transparent 35%), radial-gradient(circle at top left, rgba(20, 184, 166, 0.14), transparent 30%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-24 text-center lg:px-8 lg:py-32">
            <p class="mb-6 inline-flex rounded-full border se-border se-surface px-4 py-2 text-sm font-semibold" style="color: var(--accent);">
                Built for Nigerian businesses, creators, agencies, and teams
            </p>

            <h1 class="mx-auto max-w-5xl text-4xl font-black tracking-tight se-text-main sm:text-6xl lg:text-7xl">
                Digital tool stacks, simplified.
            </h1>

            <p class="mx-auto mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                StackEase helps you request, pay for, set up, and manage approved business tools like Canva Teams, Google Workspace, Notion, Slack, VPNs, and Microsoft 365 with guided support.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                    Request Setup Help
                </a>

                <a href="{{ route('services') }}" class="rounded-full border se-border px-7 py-4 text-base font-bold se-text-main hover:se-surface">
                    Explore Services
                </a>
            </div>

            <p class="mx-auto mt-6 max-w-2xl text-sm se-text-soft">
                StackEase is focused on approved business, productivity, collaboration, creative, AI, cloud, and security tools. We do not promote shared-password entertainment slots.
            </p>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto grid max-w-7xl gap-6 px-6 py-14 lg:grid-cols-3 lg:px-8">
            <div class="rounded-3xl border se-border se-surface-strong p-8">
                <h2 class="text-xl font-bold se-text-main">Request</h2>
                <p class="mt-3 se-text-soft">Tell us the tool, plan, seats, and setup support you need.</p>
            </div>

            <div class="rounded-3xl border se-border se-surface-strong p-8">
                <h2 class="text-xl font-bold se-text-main">Pay</h2>
                <p class="mt-3 se-text-soft">Receive a clear invoice with FX buffer, service fee, and payment instructions.</p>
            </div>

            <div class="rounded-3xl border se-border se-surface-strong p-8">
                <h2 class="text-xl font-bold se-text-main">Get Set Up</h2>
                <p class="mt-3 se-text-soft">Our team manually processes your request and guides access delivery securely.</p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    What StackEase Does
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    We help you access and manage the tools your work depends on.
                </h2>

                <p class="mt-5 text-lg leading-8 se-text-muted">
                    Many businesses need global digital tools, but payment, setup, FX changes, team access, and renewals can become stressful. StackEase gives you a guided way to request support, receive clear pricing, and manage approved tool setups.
                </p>
            </div>

            <div class="grid gap-4">
                <div class="rounded-3xl border se-border se-surface p-6">
                    <h3 class="font-bold se-text-main">Payment and setup guidance</h3>
                    <p class="mt-2 se-text-soft">Submit your request and receive a clear invoice before anything is processed.</p>
                </div>

                <div class="rounded-3xl border se-border se-surface p-6">
                    <h3 class="font-bold se-text-main">Managed subscription records</h3>
                    <p class="mt-2 se-text-soft">Track requested tools, active subscriptions, renewal dates, and support history.</p>
                </div>

                <div class="rounded-3xl border se-border se-surface p-6">
                    <h3 class="font-bold se-text-main">Secure access handling</h3>
                    <p class="mt-2 se-text-soft">Sensitive setup details are handled carefully and protected by acknowledgment steps.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Who It Helps
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    Built for people who need serious tools without operational stress.
                </h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['Freelancers', 'Designers, developers, writers, consultants, and independent professionals.'],
                    ['Small Agencies', 'Creative, marketing, web, and consulting teams managing tools for client work.'],
                    ['Creators', 'Content creators who need design, AI, storage, productivity, and collaboration tools.'],
                    ['Small Businesses', 'SMEs that need email, documentation, meetings, file storage, and secure access.'],
                    ['Churches & Ministries', 'Teams managing media, communication, operations, and online collaboration.'],
                    ['Remote Teams', 'Distributed teams that need reliable productivity and collaboration stacks.'],
                ] as [$title, $text])
                    <div class="rounded-3xl border se-border se-surface-strong p-7">
                        <h3 class="text-lg font-bold se-text-main">{{ $title }}</h3>
                        <p class="mt-3 se-text-soft">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Services
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    Start with the tools your business already needs.
                </h2>

                <p class="mt-5 text-lg se-text-muted">
                    StackEase begins with practical B2B tools for design, productivity, collaboration, security, and business operations.
                </p>
            </div>

            <a href="{{ route('services') }}" class="rounded-full border se-border px-6 py-3 text-sm font-bold se-text-main hover:se-surface">
                View all services
            </a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['Canva Teams Support', 'Request Canva Teams setup and workspace support for your creative team.'],
                ['Google Workspace Support', 'Get help with business email, storage, documents, and team setup.'],
                ['Notion Setup', 'Organize notes, databases, wikis, and internal documentation.'],
                ['Slack Setup', 'Set up team communication channels and workspace access.'],
                ['VPN Setup', 'Request support for approved VPN and security tools.'],
                ['Microsoft 365 Setup', 'Get support for Microsoft productivity, email, and collaboration tools.'],
            ] as [$title, $text])
                <div class="rounded-3xl border se-border se-surface p-7">
                    <h3 class="text-lg font-bold se-text-main">{{ $title }}</h3>
                    <p class="mt-3 se-text-soft">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    How It Works
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    A simple request-to-setup workflow.
                </h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['01', 'Submit Request', 'Tell us the tool, plan, seats, and setup need.'],
                    ['02', 'Receive Invoice', 'We review the request and send a clear invoice.'],
                    ['03', 'Payment Confirmation', 'Pay through available options or submit proof for manual review.'],
                    ['04', 'Setup & Support', 'We process the request and guide your setup securely.'],
                ] as [$number, $title, $text])
                    <div class="rounded-3xl border se-border se-surface-strong p-7">
                        <span class="text-sm font-black" style="color: var(--accent);">{{ $number }}</span>
                        <h3 class="mt-4 text-lg font-bold se-text-main">{{ $title }}</h3>
                        <p class="mt-3 se-text-soft">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Why Choose Us
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    Built around clarity, compliance, and practical support.
                </h2>

                <p class="mt-5 text-lg leading-8 se-text-muted">
                    StackEase is designed as a guided support layer for business tools, not a risky shortcut platform. The focus is clear requests, transparent invoices, careful access handling, and support after setup.
                </p>
            </div>

            <div class="grid gap-4">
                @foreach ([
                    ['B2B-first positioning', 'Focused on productivity, business, creative, AI, cloud, and security tools.'],
                    ['Clear invoice logic', 'Pricing can include provider cost, FX buffer, service fee, and gateway fee.'],
                    ['Manual review where needed', 'Riskier tools can be reviewed before approval or fulfillment.'],
                    ['Support-ready structure', 'Requests, subscriptions, invoices, payments, and tickets can be tracked.'],
                ] as [$title, $text])
                    <div class="rounded-3xl border se-border se-surface p-6">
                        <h3 class="font-bold se-text-main">{{ $title }}</h3>
                        <p class="mt-2 se-text-soft">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <div class="max-w-3xl">
                    <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                        Blog & Resources
                    </p>

                    <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                        Learn how to choose, pay for, and manage your business tools better.
                    </h2>

                    <p class="mt-5 text-lg se-text-muted">
                        Practical guides for Nigerian businesses, freelancers, creators, and teams using global digital tools.
                    </p>
                </div>

                <a href="#" class="rounded-full border se-border px-6 py-3 text-sm font-bold se-text-main hover:se-surface">
                    Visit Blog
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['How Nigerian Businesses Can Manage Global SaaS Tools Without Payment Stress', 'A practical guide to handling payment, setup, FX changes, and renewals for global digital tools.'],
                    ['Canva Teams for Small Businesses: What to Know Before You Subscribe', 'Understand seats, team access, design workflows, and setup considerations before requesting Canva Teams support.'],
                    ['Why FX Changes Affect Digital Subscription Pricing in Nigeria', 'A simple explanation of exchange rates, buffers, invoice expiry, and why clear pricing matters.'],
                ] as [$title, $excerpt])
                    <article class="rounded-3xl border se-border se-surface-strong p-7">
                        <p class="text-xs font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                            Resource
                        </p>

                        <h3 class="mt-4 text-lg font-bold leading-7 se-text-main">
                            {{ $title }}
                        </h3>

                        <p class="mt-3 se-text-soft">
                            {{ $excerpt }}
                        </p>

                        <a href="#" class="mt-6 inline-flex text-sm font-bold" style="color: var(--accent);">
                            Read article →
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-6 py-20 lg:px-8">
        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                FAQ
            </p>

            <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                Questions before you request?
            </h2>
        </div>

        <div class="mt-10 space-y-4">
            @foreach ([
                ['Is StackEase a subscription seller?', 'StackEase is positioned as a request, payment, setup, and managed support layer for approved digital tools. Some requests may require manual review before approval.'],
                ['Can I request any tool?', 'You can request supported business, productivity, creative, AI, cloud, and security tools. Restricted or risky tools may be declined.'],
                ['Do you store passwords?', 'Sensitive access or invitation details must not be stored as normal text. The platform is designed to use encrypted access payloads where necessary.'],
                ['How fast is setup?', 'Setup depends on the tool, payment confirmation, provider process, and batch window. Requests are processed after review and payment confirmation.'],
                ['Can businesses manage renewals?', 'Yes. StackEase is being built to help users track active subscriptions, renewal dates, and support tickets.'],
            ] as [$question, $answer])
                <div class="rounded-3xl border se-border se-surface-strong p-6">
                    <h3 class="font-bold se-text-main">{{ $question }}</h3>
                    <p class="mt-3 se-text-soft">{{ $answer }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 pb-20 lg:px-8">
        <div class="rounded-[2rem] border se-border se-surface-strong px-8 py-14 text-center lg:px-16">
            <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                Ready to simplify your stack?
            </p>

            <h2 class="mx-auto mt-4 max-w-3xl text-3xl font-black tracking-tight se-text-main sm:text-5xl">
                Request help with your next business tool setup.
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-lg se-text-muted">
                Submit your request and we will review the tool, plan, seats, and setup requirements before sending the next step.
            </p>

            <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                    Start a Concierge Request
                </a>

                <a href="{{ route('deals') }}" class="rounded-full border se-border px-7 py-4 text-base font-bold se-text-main hover:se-surface">
                    View Deals
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>