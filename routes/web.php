<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\AdminController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('colocations', ColocationController::class);

Route::middleware(['auth', 'check.banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('colocations', ColocationsController::class);
    Route::post('colocations/{colocation}/cancel', [ColocationsController::class, 'cancel'])->name('colocations.cancel');
    Route::post('colocations/{colocation}/leave', [ColocationsController::class, 'leave'])->name('colocations.leave');
    Route::post('colocations/{colocation}/remove/{user}', [ColocationsController::class, 'removeMember'])->name('colocations.remove');
        
    Route::post('colocations/{colocation}/invitations', [InvitationsController::class, 'store'])->name('invitations.store');
    Route::get('invitations/{token}/accept', [InvitationsController::class, 'accept'])->name('invitations.accept');
    Route::get('invitations/{token}/refuse', [InvitationsController::class, 'refuse'])->name('invitations.refuse');
    
    Route::resource('colocations.expenses', ExpensesController::class);
    Route::resource('colocations.categories', CategoriesController::class);
    // Route::post('colocations/{colocation}/payments', [PaymentsController::class, 'store'])->name('payments.store');
    
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('users/{user}/ban', [AdminController::class, 'ban'])->name('users.ban');
        Route::post('users/{user}/unban', [AdminController::class, 'unban'])->name('users.unban');
    });
});

require __DIR__.'/auth.php';
