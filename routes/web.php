<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityBlockController;
use App\Http\Controllers\BarbersApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'customer'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:barber'])->prefix('barber')->name('barber.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'barber'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::post('/availability-blocks', [AvailabilityBlockController::class, 'store'])->name('availability-blocks.store');
    Route::delete('/availability-blocks/{availabilityBlock}', [AvailabilityBlockController::class, 'destroy'])->name('availability-blocks.destroy');
    Route::get('/barbers', [BarbersApprovalController::class, 'index'])->name('barbers.index');
    Route::patch('/barbers/{barber}/approve', [BarbersApprovalController::class, 'approve'])->name('barbers.approve');
    Route::delete('/barbers/{barber}', [BarbersApprovalController::class, 'reject'])->name('barbers.reject');
});

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/{appointment}/calendar', [AppointmentController::class, 'ics'])->name('appointments.ics');
});

Route::middleware(['auth', 'verified', 'role:barber'])->group(function () {
    Route::post('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');
    Route::post('/appointments/{appointment}/decline', [AppointmentController::class, 'decline'])->name('appointments.decline');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
