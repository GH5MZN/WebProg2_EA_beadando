<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\DatabaseController;

Route::get('/', function () {
    return view('eventually-welcome');
})->name('home');

Route::get('/history', [PilotController::class, 'index'])->name('history');
Route::get('/test', [PilotController::class, 'index'])->name('test');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin routes - only for admin users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/contact-messages', [ContactController::class, 'index'])->name('admin.contact-messages');
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
});

Route::get('/diagrams', [DiagramController::class, 'index'])->name('diagrams');
Route::get('/database', [DatabaseController::class, 'index'])->name('database.index');

Route::resource('pilots', PilotController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
