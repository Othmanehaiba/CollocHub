<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColocationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'check.banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('colocations', ColocationsController::class);
    Route::post('colocations/{colocation}/cancel', [ColocationsController::class, 'cancel'])->name('colocations.cancel');
    Route::post('colocations/{colocation}/leave', [ColocationsController::class, 'leave'])->name('colocations.leave');
    Route::post('colocations/{colocation}/remove/{user}', [ColocationsController::class, 'removeMember'])->name('colocations.remove');


});

require __DIR__ . '/auth.php';