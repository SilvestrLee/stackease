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
                    Discover practical tools for design, productivity, business operations, collaboration, cloud storage, AI, and security. Some tools can be requested through StackEase, while others may be listed for awareness only.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    [
                        'name' => 'Canva Teams',
                        'category' => 'Design & Creative',
                        'status' => 'Request Support',
                        'description' => 'Design collaboration for teams creating social media graphics, presentations, brand assets, and marketing materials.',
                    ],
                    [
                        'name' => 'Google Workspace',
                        'category' => 'Business Tools',
                        'status' => 'Request Support',
                        'description' => 'Business email, cloud documents, storage, calendar, meetings, and team productivity tools.',
                    ],
                    [
                        'name' => 'Notion',
                        'category' => 'Productivity',
                        'status' => 'Request Support',
                        'description' => 'A workspace for notes, documentation, project planning, internal wikis, and structured team knowledge.',
                    ],
                    [
                        'name' => 'Slack',
                        'category' => 'Team Collaboration',
                        'status' => 'Request Support',
                        'description' => 'Team communication platform for channels, updates, collaboration, and internal coordination.',
                    ],
                    [
                        'name' => 'Microsoft 365',
                        'category' => 'Business Tools',
                        'status' => 'Request Support',
                        'description' => 'Productivity suite for email, documents, spreadsheets, presentations, cloud storage, and collaboration.',
                    ],
                    [
                        'name' => '1Password',
                        'category' => 'VPN & Security',
                        'status' => 'Review Required',
                        'description' => 'Password management for individuals, businesses, and teams that need safer credential handling.',
                    ],
                ] as $deal)
                    <article class="rounded-3xl border se-border se-surface-strong p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                                    {{ $deal['category'] }}
                                </p>

                                <h2 class="mt-4 text-xl font-black se-text-main">
                                    {{ $deal['name'] }}
                                </h2>
                            </div>

                            <span class="rounded-full border se-border px-3 py-1 text-xs font-bold se-text-soft">
                                {{ $deal['status'] }}
                            </span>
                        </div>

                        <p class="mt-5 leading-7 se-text-soft">
                            {{ $deal['description'] }}
                        </p>

                        <a href="{{ route('concierge') }}" class="mt-7 inline-flex text-sm font-bold" style="color: var(--accent);">
                            Request help →
                        </a>
                    </article>
                @endforeach
            </div>
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