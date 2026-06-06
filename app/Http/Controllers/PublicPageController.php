<?php

namespace App\Http\Controllers;

use App\Models\BatchWindow;
use App\Models\ConciergeRequest;
use App\Models\Deal;
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
        return view('public.deals', [
            'featuredDeals' => Deal::query()
                ->with(['provider', 'category'])
                ->where('status', 'published')
                ->where('is_featured', true)
                ->where(function ($query) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->latest()
                ->take(6)
                ->get(),

            'deals' => Deal::query()
                ->with(['provider', 'category'])
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->latest()
                ->paginate(12),
        ]);
    }

    public function dealShow(string $slug): View
    {
        $deal = Deal::query()
            ->with(['provider', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->firstOrFail();

        return view('public.deal-show', [
            'deal' => $deal,
        ]);
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

    public function concierge(Request $request): View
    {
        $selectedDeal = null;

        if ($request->filled('deal')) {
            $selectedDeal = Deal::query()
                ->with(['provider'])
                ->where('slug', $request->deal)
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->first();
        }

        return view('public.concierge', [
            'selectedDeal' => $selectedDeal,

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
            'deal_id' => ['nullable', 'exists:deals,id'],
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

        $selectedDeal = null;

        if (! empty($validated['deal_id'])) {
            $selectedDeal = Deal::query()
                ->where('id', $validated['deal_id'])
                ->where('status', 'published')
                ->first();
        }

        $userNotes = $validated['user_notes'];

        if ($selectedDeal) {
            $userNotes = "Deal Request: {$selectedDeal->title}\n\n" . $userNotes;
        }

        ConciergeRequest::create([
            'user_id' => $request->user()->id,
            'provider_id' => $validated['provider_id'] ?? $selectedDeal?->provider_id,
            'batch_window_id' => $validated['batch_window_id'] ?? null,
            'request_reference' => 'REQ-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'service_name' => $validated['service_name'],
            'request_type' => $validated['request_type'],
            'desired_plan' => $validated['desired_plan'] ?? null,
            'seat_count' => $validated['seat_count'],
            'duration' => $validated['duration'] ?? null,
            'budget_range' => $validated['budget_range'] ?? null,
            'existing_account' => $request->boolean('existing_account'),
            'user_notes' => $userNotes,
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