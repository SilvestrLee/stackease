<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/services', [PublicPageController::class, 'services'])->name('services');

Route::get('/deals', [PublicPageController::class, 'deals'])->name('deals');

Route::get('/deals/{slug}', [PublicPageController::class, 'dealShow'])->name('deals.show');

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard/requests', function () {
        return view('dashboard.requests', [
            'requests' => auth()->user()
                ->conciergeRequests()
                ->with(['provider', 'batchWindow', 'invoices'])
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

    Route::get('/dashboard/payment-proofs', function () {
        return view('dashboard.payment-proofs');
    })->name('dashboard.payment-proofs');

    Route::get('/dashboard/invoices/{invoice}', function (Invoice $invoice) {
        abort_unless($invoice->user_id === auth()->id(), 403);

        $invoice->load([
            'conciergeRequest',
            'pricingSnapshot',
            'payments',
        ]);

        return view('dashboard.invoice-show', [
            'invoice' => $invoice,
        ]);
    })->name('dashboard.invoices.show');

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