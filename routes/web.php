<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('home');


Route::middleware(['auth', UserMiddleware::class])->group(function () {
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/event/{eventId}/subscribe', [RegistrationController::class, 'store'])->name('event.subscribe');
    Route::delete('/event/{eventId}/unsubscribe', [RegistrationController::class, 'destroy'])->name('event.unsubscribe');
    Route::post('/notifications/read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');
});


Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [EventController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::post('/events/{id}/add-participant', [EventController::class, 'addParticipant'])->name('events.addParticipant');
    Route::delete('/events/{id}/remove-participant/{userId}', [EventController::class, 'removeParticipant'])->name('events.removeParticipant');
});


require __DIR__ . '/auth.php';
