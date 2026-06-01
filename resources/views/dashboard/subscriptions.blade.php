<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    My Subscriptions
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    View your active, pending, and renewal-related StackEase subscriptions.
                </p>
            </div>

            <a href="{{ route('concierge') }}" class="inline-flex items-center rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                New Concierge Request
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 grid gap-4 md:grid-cols-4">
                <a href="{{ route('dashboard') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    Overview
                </a>

                <a href="{{ route('dashboard.requests') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Requests
                </a>

                <a href="{{ route('dashboard.invoices') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Invoices
                </a>

                <a href="{{ route('dashboard.tickets') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    Support Tickets
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-200 px-6 py-5">
                    <h3 class="text-lg font-black text-gray-900">Subscription Records</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($subscriptions as $subscription)
                        <div class="p-6">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <p class="text-lg font-black text-gray-900">
                                        {{ $subscription->provider_name }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $subscription->subscription_reference }}
                                    </p>

                                    <div class="mt-4 grid gap-3 text-sm text-gray-600 sm:grid-cols-2 lg:grid-cols-4">
                                        <p>
                                            <span class="font-bold text-gray-900">Provider:</span>
                                            {{ $subscription->provider?->name ?? $subscription->provider_name }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Plan:</span>
                                            {{ $subscription->plan_type ?? 'Not specified' }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Seats:</span>
                                            {{ $subscription->seat_count }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Amount:</span>
                                            ₦{{ number_format($subscription->amount, 2) }}
                                        </p>
                                    </div>

                                    <div class="mt-4 grid gap-3 text-sm text-gray-600 sm:grid-cols-2">
                                        <p>
                                            <span class="font-bold text-gray-900">Start Date:</span>
                                            {{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'Not set' }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Renewal Date:</span>
                                            {{ $subscription->renewal_date ? $subscription->renewal_date->format('M d, Y') : 'Not set' }}
                                        </p>
                                    </div>

                                    @if ($subscription->access_note)
                                        <div class="mt-5 rounded-xl bg-gray-50 p-4">
                                            <p class="text-sm font-bold text-gray-900">Access / Setup Note</p>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                                {{ $subscription->access_note }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($subscription->credential)
                                        <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                                            <p class="text-sm font-bold text-emerald-800">
                                                Secure access payload available
                                            </p>
                                            <p class="mt-2 text-sm leading-6 text-emerald-700">
                                                This subscription has encrypted setup/access information. In a later phase, this will be revealed only after the acknowledgment gate is accepted.
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-[220px] rounded-2xl bg-gray-50 p-5">
                                    <p class="text-sm font-medium text-gray-500">Status</p>

                                    <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-bold capitalize
                                        @if ($subscription->status === 'active')
                                            bg-emerald-100 text-emerald-700
                                        @elseif (in_array($subscription->status, ['pending_setup', 'renewal_due']))
                                            bg-yellow-100 text-yellow-700
                                        @elseif (in_array($subscription->status, ['expired', 'suspended', 'cancelled']))
                                            bg-red-100 text-red-700
                                        @else
                                            bg-gray-100 text-gray-700
                                        @endif
                                    ">
                                        {{ str_replace('_', ' ', $subscription->status) }}
                                    </span>

                                    @if ($subscription->invoice)
                                        <p class="mt-4 text-xs text-gray-500">
                                            Invoice: {{ $subscription->invoice->invoice_reference }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6">
                            <p class="text-sm text-gray-500">
                                You do not have any subscription records yet.
                            </p>

                            <a href="{{ route('concierge') }}" class="mt-4 inline-flex rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                                Request Subscription Support
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>