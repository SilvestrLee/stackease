<x-layouts.public title="Concierge Request | StackEase">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 opacity-80" style="background: radial-gradient(circle at top right, rgba(52, 211, 153, 0.16), transparent 35%);"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <div class="max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
                    Concierge Request
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-6xl">
                    Tell us the digital tool support you need.
                </h1>

                <p class="mt-6 max-w-3xl text-lg leading-8 se-text-muted">
                    Submit a request for approved business, productivity, creative, AI, cloud, collaboration, or security tools. StackEase will review your request before sending the next step.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y se-border se-surface">
        <div class="mx-auto max-w-5xl px-6 py-16 lg:px-8">
            @if (session('success'))
                <div class="mb-8 rounded-3xl border se-border se-surface-strong p-6">
                    <p class="font-bold" style="color: var(--accent);">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @guest
                <div class="rounded-[2rem] border se-border se-surface-strong p-8 text-center lg:p-12">
                    <h2 class="text-3xl font-black se-text-main">
                        Create an account to submit a request.
                    </h2>

                    <p class="mx-auto mt-4 max-w-2xl text-lg se-text-muted">
                        Concierge requests are connected to your StackEase account so you can later track request status, invoices, payments, subscriptions, and support tickets.
                    </p>

                    <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="{{ route('register') }}" class="se-accent rounded-full px-7 py-4 text-base font-bold">
                            Create Account
                        </a>

                        <a href="{{ route('login') }}" class="rounded-full border se-border px-7 py-4 text-base font-bold se-text-main se-hover-surface">
                            Login
                        </a>
                    </div>
                </div>
            @endguest

            @auth
                @if ($selectedDeal)
                    <div class="mb-8 rounded-3xl border se-border se-surface-strong p-6">
                        <p class="text-sm font-bold uppercase tracking-[0.2em]" style="color: var(--accent);">
                            Selected Deal
                        </p>

                        <h3 class="mt-2 text-2xl font-black se-text-main">
                            {{ $selectedDeal->title }}
                        </h3>

                        <p class="mt-3 se-text-muted">
                            This request was started from a StackEase Deal.
                            Some fields have been prefilled automatically.
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('concierge.store') }}" class="rounded-[2rem] border se-border se-surface-strong p-8 lg:p-10">
                    @csrf

                    @if ($selectedDeal)
                        <input
                            type="hidden"
                            name="deal_id"
                            value="{{ $selectedDeal->id }}"
                        >
                    @endif

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Provider / Tool
                            </label>

                            <select name="provider_id" class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main">
                                <option value="">Select provider, or choose Other below</option>

                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}" @selected(old('provider_id', $selectedDeal?->provider_id) == $provider->id)>
                                        {{ $provider->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('provider_id')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Service Name
                            </label>

                            <input
                                type="text"
                                name="service_name"
                                value="{{ old('service_name', $selectedDeal?->title) }}"
                                placeholder="Example: Canva Teams setup"
                                class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main"
                                required
                            >

                            @error('service_name')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Request Type
                            </label>

                            <select name="request_type" class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main" required>
                                <option value="deal_request" @selected(old('request_type', $selectedDeal ? 'deal_request' : null) === 'deal_request')>
                                    Deal Request
                                </option>
                                <option value="subscription_setup" @selected(old('request_type') === 'subscription_setup')>Subscription Setup</option>
                                <option value="payment_support" @selected(old('request_type') === 'payment_support')>Payment Support</option>
                                <option value="renewal_management" @selected(old('request_type') === 'renewal_management')>Renewal Management</option>
                                <option value="workspace_setup" @selected(old('request_type') === 'workspace_setup')>Workspace Setup</option>
                                <option value="general_support" @selected(old('request_type') === 'general_support')>General Support</option>
                            </select>

                            @error('request_type')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Desired Plan
                            </label>

                            <input
                                type="text"
                                name="desired_plan"
                                value="{{ old('desired_plan') }}"
                                placeholder="Example: Canva Teams monthly"
                                class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main"
                            >

                            @error('desired_plan')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Number of Seats
                            </label>

                            <input
                                type="number"
                                name="seat_count"
                                value="{{ old('seat_count', 1) }}"
                                min="1"
                                max="500"
                                class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main"
                                required
                            >

                            @error('seat_count')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Preferred Duration
                            </label>

                            <select name="duration" class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main">
                                <option value="">Select duration</option>
                                <option value="monthly" @selected(old('duration') === 'monthly')>Monthly</option>
                                <option value="quarterly" @selected(old('duration') === 'quarterly')>Quarterly</option>
                                <option value="yearly" @selected(old('duration') === 'yearly')>Yearly</option>
                                <option value="one_time" @selected(old('duration') === 'one_time')>One-time setup</option>
                            </select>

                            @error('duration')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Budget Range
                            </label>

                            <input
                                type="text"
                                name="budget_range"
                                value="{{ old('budget_range') }}"
                                placeholder="Example: ₦20,000 - ₦50,000"
                                class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main"
                            >

                            @error('budget_range')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold se-text-main">
                                Preferred Batch Window
                            </label>

                            <select name="batch_window_id" class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main">
                                <option value="">No preference</option>

                                @foreach ($batchWindows as $batchWindow)
                                    <option value="{{ $batchWindow->id }}" @selected(old('batch_window_id') == $batchWindow->id)>
                                        {{ $batchWindow->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('batch_window_id')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="flex items-start gap-3">
                            <input
                                type="checkbox"
                                name="existing_account"
                                value="1"
                                @checked(old('existing_account'))
                                class="mt-1"
                            >

                            <span class="text-sm se-text-muted">
                                I already have an account/workspace with this provider.
                            </span>
                        </label>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold se-text-main">
                            Tell us what you need
                        </label>

                        <textarea
                            name="user_notes"
                            rows="6"
                            placeholder="Describe the tool, plan, number of users, setup need, deadline, and anything we should know."
                            class="mt-2 w-full rounded-2xl border se-border se-surface px-4 py-3 se-text-main"
                            required
                        >{{ old('user_notes') }}</textarea>

                        @error('user_notes')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8 rounded-3xl border se-border se-surface p-6">
                        <h3 class="font-bold se-text-main">
                            Before you submit
                        </h3>

                        <p class="mt-2 text-sm leading-6 se-text-soft">
                            Submitting a request does not guarantee approval, availability, or immediate setup. StackEase will review the request, confirm whether support is available, and send the next step where applicable.
                        </p>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="se-accent rounded-full px-8 py-4 text-base font-bold">
                            Submit Concierge Request
                        </button>
                    </div>
                </form>
            @endauth
        </div>
    </section>
</x-layouts.public>