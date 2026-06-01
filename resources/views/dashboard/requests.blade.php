<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    My Requests
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Track all your StackEase concierge requests.
                </p>
            </div>

            <a href="{{ route('concierge') }}" class="inline-flex items-center rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                New Request
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-200 px-6 py-5">
                    <h3 class="text-lg font-black text-gray-900">Request History</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($requests as $request)
                        <div class="p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <p class="text-lg font-black text-gray-900">
                                        {{ $request->service_name }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $request->request_reference }}
                                    </p>

                                    <div class="mt-4 grid gap-3 text-sm text-gray-600 sm:grid-cols-2 lg:grid-cols-4">
                                        <p>
                                            <span class="font-bold text-gray-900">Provider:</span>
                                            {{ $request->provider?->name ?? 'Not selected' }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Type:</span>
                                            {{ str_replace('_', ' ', $request->request_type) }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Seats:</span>
                                            {{ $request->seat_count }}
                                        </p>

                                        <p>
                                            <span class="font-bold text-gray-900">Batch:</span>
                                            {{ $request->batchWindow?->name ?? 'No preference' }}
                                        </p>
                                    </div>

                                    @if ($request->user_notes)
                                        <p class="mt-4 max-w-3xl text-sm leading-6 text-gray-600">
                                            {{ $request->user_notes }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-col items-start gap-2 lg:items-end">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold capitalize text-gray-700">
                                        {{ str_replace('_', ' ', $request->status) }}
                                    </span>

                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold capitalize text-emerald-700">
                                        {{ $request->priority }}
                                    </span>

                                    <p class="text-xs text-gray-400">
                                        {{ $request->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6">
                            <p class="text-sm text-gray-500">
                                You have not submitted any concierge request yet.
                            </p>

                            <a href="{{ route('concierge') }}" class="mt-4 inline-flex rounded-lg bg-emerald-500 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-600">
                                Submit Your First Request
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>