<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ContactCategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\LiveController;
use App\Models\Live;

// =========================
// PÁGINA RAÍZ
// =========================
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================
// LOGIN (solo invitados)
// =========================
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Recuperar contraseña
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])
            ->name('password.request');

        Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink'])
            ->name('password.email');

        Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])
            ->name('password.reset');

        Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])
            ->name('password.update');
    });
});

// =========================
// LOGOUT
// =========================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// PANEL ADMIN (logueados)
// =========================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])
        ->name('activity_logs.index');

    Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);

    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('news', NewsController::class);
    Route::resource('documents', DocumentController::class)->except(['show']);
    Route::resource('contact-categories', ContactCategoryController::class)->except(['show']);
    Route::resource('contacts', ContactController::class)->except(['show']);

    Route::patch('contacts/{contact}/toggle-visible',
        [ContactController::class, 'toggleVisible']
    )->name('contacts.toggle-visible');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    Route::resource('users', UserController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // =========================
    // LIVES
    // =========================
    Route::get('lives', [LiveController::class, 'index'])
    ->name('lives.index');
    // Formulario
    Route::get('lives/create', function () {
        return view('admin.lives.create');
    })->name('lives.create');
    Route::patch('lives/{live}/toggle', [LiveController::class, 'toggle'])
    ->name('lives.toggle');
    Route::delete('lives/{live}', [LiveController::class, 'destroy'])
    ->name('lives.destroy');
    // Guardar
    Route::post('lives', [LiveController::class, 'store'])
        ->name('lives.store');

    // =========================
    // CALENDARIO PÚBLICO
    // =========================
    Route::get('/calendario', function () {
        return view('public.calendar');
    })->name('public.calendar');
});

// =========================
// API (PÚBLICA)
// =========================
Route::get('/api/live', function () {
    return Live::where('is_active', true)->latest()->first();
});