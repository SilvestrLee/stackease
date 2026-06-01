<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    StackEase Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Track your requests, invoices, subscriptions, renewals, and support tickets.
                </p>
            </div>

            <a href="{{ route('concierge') }}" class="inline-flex items-center rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                New Concierge Request
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $pendingRequests->count() }}</p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Unpaid Invoices</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $unpaidInvoices->count() }}</p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $activeSubscriptions->count() }}</p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Renewal Due Soon</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $renewalDueSoon->count() }}</p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Open Tickets</p>
                    <p class="mt-3 text-3xl font-black text-gray-900">{{ $openTickets->count() }}</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-4">
                <a href="{{ route('dashboard.requests') }}" class="rounded-2xl bg-white p-5 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Requests
                </a>

                <a href="{{ route('dashboard.invoices') }}" class="rounded-2xl bg-white p-5 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Invoices
                </a>

                <a href="{{ route('dashboard.subscriptions') }}" class="rounded-2xl bg-white p-5 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Subscriptions
                </a>

                <a href="{{ route('dashboard.tickets') }}" class="rounded-2xl bg-white p-5 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    Support Tickets
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-900">Recent Requests</h3>
                        <a href="{{ route('dashboard.requests') }}" class="text-sm font-bold text-emerald-600">View all</a>
                    </div>

                    <div class="mt-5 space-y-4">
                        @forelse ($pendingRequests as $request)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $request->service_name }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ $request->request_reference }}</p>
                                    </div>

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                        {{ str_replace('_', ' ', $request->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No pending requests yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-900">Unpaid Invoices</h3>
                        <a href="{{ route('dashboard.invoices') }}" class="text-sm font-bold text-emerald-600">View all</a>
                    </div>

                    <div class="mt-5 space-y-4">
                        @forelse ($unpaidInvoices as $invoice)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $invoice->invoice_reference }}</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            ₦{{ number_format($invoice->total_naira_amount, 2) }}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                        {{ str_replace('_', ' ', $invoice->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No unpaid invoices.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-900">Active Subscriptions</h3>
                        <a href="{{ route('dashboard.subscriptions') }}" class="text-sm font-bold text-emerald-600">View all</a>
                    </div>

                    <div class="mt-5 space-y-4">
                        @forelse ($activeSubscriptions as $subscription)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $subscription->provider_name }}</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $subscription->plan_type ?? 'Plan not specified' }} · {{ $subscription->seat_count }} seat(s)
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        {{ str_replace('_', ' ', $subscription->status) }}
                                    </span>
                                </div>

                                @if ($subscription->renewal_date)
                                    <p class="mt-3 text-sm text-gray-500">
                                        Renewal: {{ $subscription->renewal_date->format('M d, Y') }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No active subscriptions yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-900">Open Support Tickets</h3>
                        <a href="{{ route('dashboard.tickets') }}" class="text-sm font-bold text-emerald-600">View all</a>
                    </div>

                    <div class="mt-5 space-y-4">
                        @forelse ($openTickets as $ticket)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $ticket->subject }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ $ticket->ticket_reference }}</p>
                                    </div>

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                        {{ str_replace('_', ' ', $ticket->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No open support tickets.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>