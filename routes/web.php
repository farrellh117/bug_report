<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugReportController; // Hanya ini saja, hapus DeveloperBugReportController

Route::get('/', function () {
    return view('welcome');
});

// Route login
Route::get('/login', [BugReportController::class, 'showLoginForm'])->name('login');
Route::post('/login', [BugReportController::class, 'login']);

// Route registrasi
Route::get('/register', [BugReportController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [BugReportController::class, 'register']);

// Route logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Middleware auth untuk proteksi route selanjutnya
Route::middleware('auth')->group(function () {

    // Redirect ke dashboard sesuai role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'bug_tester') {
            return redirect()->route('bug_tester.dashboard');
        } elseif ($user->role === 'developer') {
            return redirect()->route('developer.dashboard');
        }

        abort(403, 'Unauthorized action.');
    })->name('dashboard');

    // Bug Tester routes
    Route::prefix('bug-tester')->name('bug_tester.')->group(function () {
        Route::get('/dashboard', [BugReportController::class, 'testerDashboard'])->name('dashboard');

        Route::resource('bug-reports', BugReportController::class);
    });

    // Developer routes
    Route::prefix('developer')->name('developer.')->group(function () {
        Route::get('/dashboard', [BugReportController::class, 'developerDashboard'])->name('dashboard');

        // Jika kamu hanya ingin beberapa method yang tersedia untuk developer
        Route::resource('bug-reports', BugReportController::class)
            ->only(['index', 'show', 'edit', 'update']);
    });
});
