<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ──────────────────────────────────────────────────────────
//  USER ROUTES  (dosen, mahasiswa, pemohon)
// ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'user-role:dosen,mahasiswa,pemohon'])->group(function () {
    Route::get('/home', [HomeController::class, 'userHome'])->name('home');

    // ── Peminjaman Ruang ──────────────────────────────
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');

    // ── Layanan Pengujian ─────────────────────────────
    Route::get('/test-requests', [App\Http\Controllers\TestRequestController::class, 'index'])->name('test-requests.index');
    Route::get('/test-requests/create', [App\Http\Controllers\TestRequestController::class, 'create'])->name('test-requests.create');
    Route::post('/test-requests', [App\Http\Controllers\TestRequestController::class, 'store'])->name('test-requests.store');
    Route::get('/test-requests/{testRequest}', [App\Http\Controllers\TestRequestController::class, 'show'])->name('test-requests.show');
    Route::post('/test-requests/{testRequest}/payment', [App\Http\Controllers\TestRequestController::class, 'uploadPayment'])->name('test-requests.upload-payment')->middleware('throttle:5,1');

    // ── Layanan Praktikum ─────────────────────────────
    Route::get('/practicum', [App\Http\Controllers\PracticumController::class, 'index'])->name('practicum.index');
    Route::get('/practicum/create', [App\Http\Controllers\PracticumController::class, 'create'])->name('practicum.create');
    Route::post('/practicum', [App\Http\Controllers\PracticumController::class, 'store'])->name('practicum.store');
    Route::get('/practicum/{practicum}', [App\Http\Controllers\PracticumController::class, 'show'])->name('practicum.show');
    Route::post('/practicum/{practicum}/report', [App\Http\Controllers\PracticumController::class, 'submitReport'])->name('practicum.submit-report')->middleware('throttle:5,1');
});

// ──────────────────────────────────────────────────────────
//  ADMIN ROUTES  (admin, admin-fakultas, admin-lab)
// ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'user-role:admin,admin-fakultas,admin-lab,penguji,reviewer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

    // ── Role Management ───────────────────────────────
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // ── Menu Management ───────────────────────────────
    Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::resource('menus', MenuController::class);

    // ── Profile ───────────────────────────────────────
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // ── Room Management ───────────────────────────────
    Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);

    // ── User Management ───────────────────────────────
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');

    // ── Booking Approval ──────────────────────────────
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingApprovalController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingApprovalController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/approve', [App\Http\Controllers\Admin\BookingApprovalController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [App\Http\Controllers\Admin\BookingApprovalController::class, 'reject'])->name('bookings.reject');

    // ── Equipment Management ──────────────────────────
    Route::resource('equipment', App\Http\Controllers\Admin\EquipmentController::class);

    // ── Test Parameter Management ─────────────────────
    Route::resource('test-parameters', App\Http\Controllers\Admin\TestParameterController::class)->except(['show']);

    // ── Pengujian (Test Request Admin) ────────────────
    Route::get('/test-requests', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'index'])->name('test-requests.index');
    Route::get('/test-requests/payments', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'payments'])->name('test-requests.payments');
    Route::get('/test-requests/{testRequest}', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'show'])->name('test-requests.show');
    Route::patch('/test-requests/{testRequest}/verify-payment', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'verifyPayment'])->name('test-requests.verify-payment');
    Route::patch('/test-requests/{testRequest}/assign', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'assign'])->name('test-requests.assign');
    Route::patch('/test-requests/{testRequest}/approve-report', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'approveReport'])->name('test-requests.approve-report');
    Route::patch('/test-requests/{testRequest}/complete', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'complete'])->name('test-requests.complete');
    Route::post('/test-requests/{testRequest}/upload-report', [App\Http\Controllers\Admin\TestRequestAdminController::class, 'uploadReport'])->name('test-requests.upload-report')->middleware('throttle:5,1');

    // ── Praktikum Admin ───────────────────────────────
    Route::get('/practicum', [App\Http\Controllers\Admin\PracticumAdminController::class, 'index'])->name('practicum.index');
    Route::get('/practicum/reports', [App\Http\Controllers\Admin\PracticumAdminController::class, 'reports'])->name('practicum.reports');
    Route::get('/practicum/export', [App\Http\Controllers\Admin\PracticumAdminController::class, 'export'])->name('practicum.export');
    Route::get('/practicum/{practicum}', [App\Http\Controllers\Admin\PracticumAdminController::class, 'show'])->name('practicum.show');
    Route::patch('/practicum/{practicum}/status', [App\Http\Controllers\Admin\PracticumAdminController::class, 'updateStatus'])->name('practicum.update-status');

    // ── Menu Search ───────────────────────────────────
    Route::get('/menu-search', [MenuController::class, 'search'])->name('menus.search');
});
