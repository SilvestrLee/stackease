<x-layouts.public title="Managed Subscriptions | StackEase">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Managed Subscriptions
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    Keep your business tools organized, renewed, and supported.
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    StackEase helps businesses, agencies, creators, ministries, and teams keep track of approved digital tool subscriptions, setup records, renewal dates, access notes, and support requests.
                </p>

                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold text-center">
                        Request Subscription Support
                    </a>

                    <a href="{{ route('services') }}" class="rounded-full border se-border px-7 py-4 text-base font-bold se-text-main text-center se-hover-surface">
                        View Supported Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    [
                        'title' => 'Central Subscription Records',
                        'text' => 'Keep records of tools requested through StackEase, including provider name, plan type, seats, status, start date, and renewal date.',
                    ],
                    [
                        'title' => 'Renewal Awareness',
                        'text' => 'Track upcoming renewal dates so your team is not surprised when important tools are due for payment or review.',
                    ],
                    [
                        'title' => 'Payment and Invoice History',
                        'text' => 'Connect subscriptions to invoices and payment records so business owners can understand what was paid and why.',
                    ],
                    [
                        'title' => 'Setup and Access Notes',
                        'text' => 'Store safe user-facing setup notes while keeping sensitive access payloads encrypted and protected.',
                    ],
                    [
                        'title' => 'Support Ticket Connection',
                        'text' => 'Open support tickets linked to a subscription when users need help with access, setup, renewal, or provider issues.',
                    ],
                    [
                        'title' => 'Team-Friendly Workflow',
                        'text' => 'Designed for small agencies, creator teams, ministries, SMEs, and remote teams managing multiple tools.',
                    ],
                ] as $item)
                    <article class="rounded-3xl border se-border se-surface-strong p-7">
                        <h2 class="text-xl font-black se-text-main">{{ $item['title'] }}</h2>
                        <p class="mt-4 leading-7 se-text-soft">{{ $item['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Built for Teams
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    One place to understand what tools your business depends on.
                </h2>

                <p class="mt-5 text-lg leading-8 se-text-muted">
                    Many teams use several tools at once: design tools, email, documentation, communication, storage, security, AI, and productivity platforms. StackEase is being built to help you track those tools in a more organized way.
                </p>
            </div>

            <div class="rounded-[2rem] border se-border se-surface-strong p-8">
                <h3 class="text-xl font-black se-text-main">
                    Example managed stack
                </h3>

                <div class="mt-6 space-y-4">
                    @foreach ([
                        ['Canva Teams', 'Design collaboration', 'Active'],
                        ['Google Workspace', 'Business email and docs', 'Active'],
                        ['Notion', 'Internal documentation', 'Setup in progress'],
                        ['Slack', 'Team communication', 'Pending request'],
                        ['1Password', 'Credential management', 'Review required'],
                    ] as [$tool, $purpose, $status])
                        <div class="rounded-2xl border se-border se-surface p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="font-bold se-text-main">{{ $tool }}</h4>
                                    <p class="mt-1 text-sm se-text-soft">{{ $purpose }}</p>
                                </div>

                                <span class="rounded-full border se-border px-3 py-1 text-xs font-bold se-text-soft">
                                    {{ $status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Security Reminder
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    Sensitive access details should not live in normal text.
                </h2>

                <p class="mt-5 text-lg leading-8 se-text-muted">
                    StackEase is being designed so user-facing notes stay safe and non-sensitive, while private setup or invitation data is stored only in encrypted payloads where necessary.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['Safe Note', 'Your workspace invitation has been sent to your email.'],
                    ['Encrypted Payload', 'Private setup information is encrypted before storage.'],
                    ['Acknowledgment Gate', 'Users must accept terms before sensitive setup details are revealed.'],
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
        <div class="rounded-[2rem] border se-border se-surface-strong px-8 py-14 text-center lg:px-16">
            <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                Ready to organize your stack?
            </p>

            <h2 class="mx-auto mt-4 max-w-3xl text-3xl font-black tracking-tight se-text-main sm:text-5xl">
                Start with a concierge request.
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-lg se-text-muted">
                Tell us the tool you need help with, the number of seats, the desired plan, and your setup requirements.
            </p>

            <div class="mt-8">
                <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                    Submit Request
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>