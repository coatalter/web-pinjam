<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// User Routes
Route::middleware(['auth', 'user-role:dosen,mahasiswa'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'userHome'])->name('home');

    // User Booking
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
});

// Admin Routes
Route::middleware(['auth', 'user-role:admin,admin-fakultas'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('home');

    // Role Management
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // Menu Management
    Route::resource('menus', App\Http\Controllers\Admin\MenuController::class);

    // Profile
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Room Management
    Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);

    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');

    // Booking Approval
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingApprovalController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingApprovalController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/approve', [App\Http\Controllers\Admin\BookingApprovalController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [App\Http\Controllers\Admin\BookingApprovalController::class, 'reject'])->name('bookings.reject');
});