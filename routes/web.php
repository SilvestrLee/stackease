<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/services', [PublicPageController::class, 'services'])->name('services');

Route::get('/deals', [PublicPageController::class, 'deals'])->name('deals');

Route::get('/resources', [PublicPageController::class, 'resources'])->name('resources.index');

Route::get('/resources/{slug}', [PublicPageController::class, 'resourceShow'])->name('resources.show');

Route::get('/concierge-request', [PublicPageController::class, 'concierge'])->name('concierge');

Route::post('/concierge-request', [PublicPageController::class, 'storeConciergeRequest'])
    ->middleware(['auth', 'verified'])
    ->name('concierge.store');

Route::get('/managed-subscriptions', [PublicPageController::class, 'managedSubscriptions'])->name('managed-subscriptions');

Route::get('/terms-of-use', [PublicPageController::class, 'terms'])->name('policies.terms');

Route::get('/privacy-policy', [PublicPageController::class, 'privacy'])->name('policies.privacy');

Route::get('/refund-policy', [PublicPageController::class, 'refund'])->name('policies.refund');

Route::get('/subscription-policy', [PublicPageController::class, 'subscriptionPolicy'])->name('policies.subscription');

Route::get('/acceptable-use-policy', [PublicPageController::class, 'acceptableUse'])->name('policies.acceptable-use');

Route::get('/disclaimer', [PublicPageController::class, 'disclaimer'])->name('policies.disclaimer');

Route::get('/dashboard', function () {
    $user = auth()->user();

    return view('dashboard', [
        'pendingRequests' => $user->conciergeRequests()
            ->whereNotIn('status', ['completed', 'cancelled', 'refunded'])
            ->latest()
            ->take(5)
            ->get(),

        'unpaidInvoices' => $user->invoices()
            ->whereIn('status', ['sent', 'awaiting_payment', 'expired_paid_flagged', 'underpaid_action_required'])
            ->latest()
            ->take(5)
            ->get(),

        'activeSubscriptions' => $user->subscriptions()
            ->whereIn('status', ['active', 'pending_setup', 'renewal_due'])
            ->latest()
            ->take(5)
            ->get(),

        'renewalDueSoon' => $user->subscriptions()
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '<=', now()->addDays(7))
            ->latest('renewal_date')
            ->take(5)
            ->get(),

        'openTickets' => $user->supportTickets()
            ->whereNotIn('status', ['resolved', 'closed'])
            ->latest()
            ->take(5)
            ->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/requests', function () {
        return view('dashboard.requests', [
            'requests' => auth()->user()
                ->conciergeRequests()
                ->with(['provider', 'batchWindow'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.requests');

    Route::get('/dashboard/invoices', function () {
        return view('dashboard.invoices', [
            'invoices' => auth()->user()
                ->invoices()
                ->with(['conciergeRequest'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.invoices');

    Route::get('/dashboard/subscriptions', function () {
        return view('dashboard.subscriptions', [
            'subscriptions' => auth()->user()
                ->subscriptions()
                ->with(['provider', 'invoice'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.subscriptions');

    Route::get('/dashboard/tickets', function () {
        return view('dashboard.tickets', [
            'tickets' => auth()->user()
                ->supportTickets()
                ->with(['subscription', 'conciergeRequest'])
                ->latest()
                ->get(),
        ]);
    })->name('dashboard.tickets');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';