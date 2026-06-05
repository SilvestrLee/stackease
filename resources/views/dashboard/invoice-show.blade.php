<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Invoice {{ $invoice->invoice_reference }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Review your invoice details and payment status.
                </p>
            </div>

            <a href="{{ route('dashboard.invoices') }}"
               class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-bold text-white hover:bg-gray-800">
                Back to Invoices
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 lg:col-span-2">
                    <h3 class="text-lg font-black text-gray-900">Invoice Summary</h3>

                    <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-bold text-gray-500">Invoice Reference</dt>
                            <dd class="mt-1 text-gray-900">{{ $invoice->invoice_reference }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Status</dt>
                            <dd class="mt-1 capitalize text-gray-900">{{ str_replace('_', ' ', $invoice->status) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Request Reference</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $invoice->conciergeRequest?->request_reference ?? 'Not linked' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Currency</dt>
                            <dd class="mt-1 text-gray-900">{{ $invoice->currency ?? 'NGN' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Base USD Cost</dt>
                            <dd class="mt-1 text-gray-900">${{ number_format($invoice->base_usd_cost, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">FX Rate</dt>
                            <dd class="mt-1 text-gray-900">₦{{ number_format($invoice->fx_rate, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">FX Buffer</dt>
                            <dd class="mt-1 text-gray-900">{{ number_format($invoice->fx_buffer_percent, 2) }}%</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">FX Buffer Amount</dt>
                            <dd class="mt-1 text-gray-900">₦{{ number_format($invoice->fx_buffer_applied, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Service Fee</dt>
                            <dd class="mt-1 text-gray-900">₦{{ number_format($invoice->service_fee, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Gateway Fee</dt>
                            <dd class="mt-1 text-gray-900">₦{{ number_format($invoice->gateway_fee, 2) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Sent At</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $invoice->sent_at ? $invoice->sent_at->format('M d, Y h:i A') : 'Not sent' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Expires At</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $invoice->expires_at ? $invoice->expires_at->format('M d, Y h:i A') : 'Not set' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-bold text-gray-500">Paid At</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $invoice->paid_at ? $invoice->paid_at->format('M d, Y h:i A') : 'Not paid yet' }}
                            </dd>
                        </div>
                    </dl>

                    @if ($invoice->notes)
                        <div class="mt-6 rounded-xl bg-gray-50 p-4">
                            <h4 class="text-sm font-black text-gray-900">Invoice Notes</h4>
                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Amount Due</p>

                    <p class="mt-2 text-3xl font-black text-gray-900">
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

                    <div class="mt-6">
                        @if ($invoice->status === 'awaiting_payment')
                            <button type="button"
                                    class="w-full rounded-lg bg-emerald-500 px-4 py-3 text-sm font-black text-white hover:bg-emerald-600">
                                Pay Now
                            </button>

                            <p class="mt-3 text-xs leading-5 text-gray-500">
                                Online payment will be powered by Paystack. This button will be connected in Phase 9.1.
                            </p>
                        @elseif ($invoice->status === 'paid')
                            <div class="rounded-xl bg-emerald-50 p-4 text-sm font-bold text-emerald-700">
                                This invoice has been paid.
                            </div>
                        @elseif ($invoice->status === 'expired')
                            <div class="rounded-xl bg-red-50 p-4 text-sm font-bold text-red-700">
                                This invoice has expired. Please request recalculation.
                            </div>
                        @elseif ($invoice->status === 'cancelled')
                            <div class="rounded-xl bg-red-50 p-4 text-sm font-bold text-red-700">
                                This invoice has been cancelled.
                            </div>
                        @elseif ($invoice->status === 'refunded')
                            <div class="rounded-xl bg-gray-50 p-4 text-sm font-bold text-gray-700">
                                This invoice has been refunded.
                            </div>
                        @else
                            <div class="rounded-xl bg-gray-50 p-4 text-sm font-bold text-gray-700">
                                Current status: {{ str_replace('_', ' ', $invoice->status) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 rounded-xl bg-gray-50 p-4">
                        <h4 class="text-sm font-black text-gray-900">Payment Notice</h4>
                        <p class="mt-2 text-xs leading-5 text-gray-500">
                            FX-sensitive invoices are valid only until the expiry time shown. Late or incomplete payments may require admin review or recalculation.
                        </p>
                    </div>
                </div>
            </div>

            @if ($invoice->payments->count())
                <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-black text-gray-900">Payment Records</h3>

                    <div class="mt-4 divide-y divide-gray-200">
                        @foreach ($invoice->payments as $payment)
                            <div class="py-4">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="font-bold text-gray-900">
                                            {{ $payment->payment_reference }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ ucfirst($payment->gateway) }} · {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                        </p>
                                    </div>

                                    <p class="font-black text-gray-900">
                                        ₦{{ number_format($payment->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>