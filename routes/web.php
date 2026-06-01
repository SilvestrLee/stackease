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

Route::get('/managed-subscriptions', [PublicPageController::class, 'managedSubscriptions'])->name('managed-subscriptions');

Route::get('/terms-of-use', [PublicPageController::class, 'terms'])->name('policies.terms');

Route::get('/privacy-policy', [PublicPageController::class, 'privacy'])->name('policies.privacy');

Route::get('/refund-policy', [PublicPageController::class, 'refund'])->name('policies.refund');

Route::get('/subscription-policy', [PublicPageController::class, 'subscriptionPolicy'])->name('policies.subscription');

Route::get('/acceptable-use-policy', [PublicPageController::class, 'acceptableUse'])->name('policies.acceptable-use');

Route::get('/disclaimer', [PublicPageController::class, 'disclaimer'])->name('policies.disclaimer');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';