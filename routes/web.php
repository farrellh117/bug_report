<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BugReportController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Route login
Route::get('/login', [BugReportController::class, 'showLoginForm'])->name('login');
Route::post('/login', [BugReportController::class, 'login']);

// Route registrasi (letakkan di sini, di luar middleware auth)
Route::get('/register', [BugReportController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [BugReportController::class, 'register']);

// Route logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Route yang butuh autentikasi dan role-based access control
// Contoh untuk bug_tester
Route::middleware(['auth', RoleMiddleware::class . ':bug_tester'])->group(function () {
    Route::get('/bug-tester/dashboard', [BugReportController::class, 'testerDashboard']);
    // Tambahkan route lain yang hanya boleh diakses bug_tester di sini
});

// Contoh untuk developer
Route::middleware(['auth', RoleMiddleware::class . ':developer'])->group(function () {
    Route::get('/developer/dashboard', [BugReportController::class, 'developerDashboard']);
    // Tambahkan route lain yang hanya boleh diakses developer di sini
});

// Contoh untuk bug_tester dan developer bisa akses bersama
Route::middleware(['auth', RoleMiddleware::class . ':bug_tester,developer'])->group(function () {
    Route::resource('bug-reports', BugReportController::class)->except(['showLoginForm', 'login']);
    // Route ini menggantikan route resource bug-reports yang sebelumnya hanya dilindungi auth
});
