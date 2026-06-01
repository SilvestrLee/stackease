<?php

namespace App\Http\Controllers;

use App\Models\BatchWindow;
use App\Models\ConciergeRequest;
use App\Models\Provider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function home(): View
    {
        return view('public.home');
    }

    public function services(): View
    {
        return view('public.services');
    }

    public function deals(): View
    {
        return view('public.deals');
    }

    public function resources(): View
    {
        return view('public.resources.index');
    }

    public function resourceShow(string $slug): View
    {
        return view('public.resources.show', [
            'slug' => $slug,
        ]);
    }

    public function concierge(): View
    {
        return view('public.concierge', [
            'providers' => Provider::where('status', 'active')
                ->orderBy('name')
                ->get(),

            'batchWindows' => BatchWindow::where('status', 'active')
                ->orderBy('cutoff_time')
                ->get(),
        ]);
    }

    public function storeConciergeRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'provider_id' => ['nullable', 'exists:providers,id'],
            'batch_window_id' => ['nullable', 'exists:batch_windows,id'],
            'service_name' => ['required', 'string', 'max:255'],
            'request_type' => ['required', 'string', 'max:255'],
            'desired_plan' => ['nullable', 'string', 'max:255'],
            'seat_count' => ['required', 'integer', 'min:1', 'max:500'],
            'duration' => ['nullable', 'string', 'max:255'],
            'budget_range' => ['nullable', 'string', 'max:255'],
            'existing_account' => ['nullable', 'boolean'],
            'user_notes' => ['required', 'string', 'max:5000'],
        ]);

        ConciergeRequest::create([
            'user_id' => $request->user()->id,
            'provider_id' => $validated['provider_id'] ?? null,
            'batch_window_id' => $validated['batch_window_id'] ?? null,
            'request_reference' => 'REQ-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'service_name' => $validated['service_name'],
            'request_type' => $validated['request_type'],
            'desired_plan' => $validated['desired_plan'] ?? null,
            'seat_count' => $validated['seat_count'],
            'duration' => $validated['duration'] ?? null,
            'budget_range' => $validated['budget_range'] ?? null,
            'existing_account' => $request->boolean('existing_account'),
            'user_notes' => $validated['user_notes'],
            'status' => 'submitted',
            'priority' => 'normal',
        ]);

        return redirect()
            ->route('concierge')
            ->with('success', 'Your concierge request has been submitted successfully. Our team will review it and follow up with the next step.');
    }

    public function managedSubscriptions(): View
    {
        return view('public.managed-subscriptions');
    }

    public function terms(): View
    {
        return view('public.policies.terms');
    }

    public function privacy(): View
    {
        return view('public.policies.privacy');
    }

    public function refund(): View
    {
        return view('public.policies.refund');
    }

    public function subscriptionPolicy(): View
    {
        return view('public.policies.subscription-policy');
    }

    public function acceptableUse(): View
    {
        return view('public.policies.acceptable-use');
    }

    public function disclaimer(): View
    {
        return view('public.policies.disclaimer');
    }
}