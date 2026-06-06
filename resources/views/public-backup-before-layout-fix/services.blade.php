<x-layouts.public title="Services | StackEase">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    StackEase Services
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    Practical setup support for the tools your business depends on.
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    StackEase helps businesses, creators, agencies, ministries, and teams request guided support for approved digital tools. We focus on clear requests, transparent invoices, manual review where needed, and secure access handling.
                </p>

                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold text-center">
                        Request Setup Help
                    </a>

                    <a href="{{ route('deals') }}" class="rounded-full border se-border px-7 py-4 text-base font-bold se-text-main text-center hover:se-surface">
                        View Deals
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
                        'title' => 'Canva Teams Support',
                        'summary' => 'Get help requesting Canva Teams setup, workspace access, seat planning, and team design workflow support.',
                        'items' => ['Team workspace guidance', 'Seat count planning', 'Access invitation support', 'Renewal tracking'],
                    ],
                    [
                        'title' => 'Google Workspace Support',
                        'summary' => 'Request help with business email, cloud documents, storage, meetings, and workspace setup.',
                        'items' => ['Business email guidance', 'Workspace setup support', 'User and team planning', 'Admin handover guidance'],
                    ],
                    [
                        'title' => 'Notion Setup',
                        'summary' => 'Organize internal documentation, project spaces, team wikis, databases, and productivity workflows.',
                        'items' => ['Workspace structure', 'Team wiki setup', 'Database planning', 'Documentation flow'],
                    ],
                    [
                        'title' => 'Slack Setup',
                        'summary' => 'Set up a communication workspace for teams that need structured channels and collaboration.',
                        'items' => ['Workspace setup guidance', 'Channel structure', 'Team invitation support', 'Basic onboarding notes'],
                    ],
                    [
                        'title' => 'VPN Setup',
                        'summary' => 'Request guided support for approved VPN and security tools for safer business access.',
                        'items' => ['Provider review', 'Plan guidance', 'Setup support', 'Security-aware handling'],
                    ],
                    [
                        'title' => 'Microsoft 365 Setup',
                        'summary' => 'Get support for Microsoft productivity tools, email, storage, and collaboration workflows.',
                        'items' => ['Plan guidance', 'Team setup support', 'Productivity apps', 'Renewal tracking'],
                    ],
                ] as $service)
                    <article class="rounded-3xl border se-border se-surface-strong p-7">
                        <h2 class="text-xl font-black se-text-main">{{ $service['title'] }}</h2>

                        <p class="mt-4 leading-7 se-text-soft">
                            {{ $service['summary'] }}
                        </p>

                        <ul class="mt-6 space-y-3">
                            @foreach ($service['items'] as $item)
                                <li class="flex gap-3 text-sm se-text-muted">
                                    <span style="color: var(--accent);" class="font-black">✓</span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('concierge') }}" class="mt-7 inline-flex text-sm font-bold" style="color: var(--accent);">
                            Request this service →
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    How We Handle Requests
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight se-text-main sm:text-4xl">
                    Not every tool request is automatically approved.
                </h2>

                <p class="mt-5 text-lg leading-8 se-text-muted">
                    StackEase is built to stay practical and careful. Some tools are approved for normal processing, while others may require review based on provider rules, risk level, payment conditions, or setup requirements.
                </p>
            </div>

            <div class="grid gap-4">
                @foreach ([
                    ['Approved', 'Can be processed normally after review, invoice, and payment confirmation.'],
                    ['Review Required', 'Needs admin review before a quote or setup path is confirmed.'],
                    ['Deal Only', 'May be listed as a useful deal but not managed directly by StackEase.'],
                    ['Restricted or Barred', 'Requests may be declined if they are risky, unsupported, or unsuitable.'],
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
        <div class="mx-auto max-w-7xl px-6 py-20 text-center lg:px-8">
            <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                Need something else?
            </p>

            <h2 class="mx-auto mt-4 max-w-3xl text-3xl font-black tracking-tight se-text-main sm:text-5xl">
                Request a tool and we’ll review if it fits the StackEase support model.
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-lg se-text-muted">
                If the tool is not listed yet, you can still submit a request. We will review it before confirming whether support is available.
            </p>

            <div class="mt-8">
                <a href="{{ route('concierge') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                    Submit a Concierge Request
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>