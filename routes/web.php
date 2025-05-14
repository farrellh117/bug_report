<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('bug-reports', BugReportController::class);