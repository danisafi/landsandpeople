<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;

// Home route (with reviews)
Route::get('/', function () {
    $reviews = Review::latest()->take(6)->get();
    return view('home', compact('reviews'));
})->name('home');

// Booking route (public)
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// Review route
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Other Booking routes (require login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/packages', function () {
        return view('packages');
    })->name('packages');
});
