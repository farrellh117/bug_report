<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BugReportController;

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

// Route bug report yang dilindungi middleware auth
Route::middleware('auth')->group(function () {
    Route::resource('bug-reports', BugReportController::class)->except(['showLoginForm', 'login']);
});
