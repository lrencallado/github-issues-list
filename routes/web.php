<?php

use App\Http\Controllers\Github\IssueController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(IssueController::class)->prefix('issues')->group(function () {
        Route::get('/', 'index')->name('issues.index');
        Route::get('/{issue_number}', 'show')->name('issues.show');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
