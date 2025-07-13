<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\DeveloperBugReportController;
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
// Untuk bug_tester
Route::middleware(['auth', RoleMiddleware::class . ':bug_tester'])->group(function () {
    Route::get('/bug-tester/dashboard', [BugReportController::class, 'testerDashboard'])->name('bug_tester.dashboard');

    // Resource bug reports khusus bug_tester
    Route::resource('bug-reports', BugReportController::class)->except(['showLoginForm', 'login']);
});

// Untuk developer dengan controller khusus DeveloperBugReportController
Route::middleware(['auth', RoleMiddleware::class . ':developer'])->prefix('developer')->name('developer.')->group(function () {
    Route::get('/dashboard', [DeveloperBugReportController::class, 'index'])->name('dashboard');

    // Resource bug reports untuk developer, route resource dengan prefix & nama route yang sesuai
    Route::resource('bug-reports', DeveloperBugReportController::class)
        ->only(['index', 'show', 'edit', 'update']);
});
