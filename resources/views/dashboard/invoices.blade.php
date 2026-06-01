<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    My Invoices
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    View your StackEase invoice history and payment status.
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

                <a href="{{ route('dashboard.subscriptions') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    My Subscriptions
                </a>

                <a href="{{ route('dashboard.tickets') }}" class="rounded-2xl bg-white p-4 text-center font-bold text-gray-800 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50">
                    Support Tickets
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-200 px-6 py-5">
                    <h3 class="text-lg font-black text-gray-900">Invoice History</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($invoices as $invoice)
                        <div class="p-6">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <p class="text-lg font-black text-gray-900">
                                        {{ $invoice->invoice_reference }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Request:
                                        {{ $invoice->conciergeRequest?->request_reference ?? 'Not linked' }}
                                    </p>

                                    <div class="mt-4 grid gap-3 text-sm text-gray-600 sm:grid-cols-2 lg:grid-cols-4">
                                        <p>
                                            <span class="font-bold text-gray-900">USD Cost:</span>
                                            ${{ number_format($invoice->base_usd_cost, 2) }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">FX Rate:</span>
                                            ₦{{ number_format($invoice->fx_rate, 2) }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">FX Buffer:</span>
                                            {{ number_format($invoice->fx_buffer_percent, 2) }}%
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Service Fee:</span>
                                            ₦{{ number_format($invoice->service_fee, 2) }}
                                        </p>
                                    </div>

                                    @if ($invoice->notes)
                                        <p class="mt-4 max-w-3xl text-sm leading-6 text-gray-600">
                                            {{ $invoice->notes }}
                                        </p>
                                    @endif
                                </div>

                                <div class="min-w-[220px] rounded-2xl bg-gray-50 p-5">
                                    <p class="text-sm font-medium text-gray-500">Total Amount</p>

                                    <p class="mt-2 text-2xl font-black text-gray-900">
                                        ₦{{ number_format($invoice->total_naira_amount, 2) }}
                                    </p>

                                    <span class="mt-4 inline-flex rounded-full px-3 py-1 text-xs font-bold capitalize
                                        @if ($invoice->status === 'paid')
                                            bg-emerald-100 text-emerald-700
                                        @elseif (in_array($invoice->status, ['sent', 'awaiting_payment']))
                                            bg-yellow-100 text-yellow-700
                                        @elseif (in_array($invoice->status, ['expired', 'cancelled']))
                                            bg-red-100 text-red-700
                                        @else
                                            bg-gray-100 text-gray-700
                                        @endif
                                    ">
                                        {{ str_replace('_', ' ', $invoice->status) }}
                                    </span>

                                    @if ($invoice->expires_at)
                                        <p class="mt-4 text-xs text-gray-500">
                                            Expires: {{ $invoice->expires_at->format('M d, Y h:i A') }}
                                        </p>
                                    @endif

                                    @if ($invoice->paid_at)
                                        <p class="mt-2 text-xs text-gray-500">
                                            Paid: {{ $invoice->paid_at->format('M d, Y h:i A') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6">
                            <p class="text-sm text-gray-500">
                                You do not have any invoices yet.
                            </p>

                            <a href="{{ route('concierge') }}" class="mt-4 inline-flex rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                                Submit a Request
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>