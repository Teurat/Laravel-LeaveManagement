<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveTypeController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/companies/import', [CompanyController::class, 'import'])->name('companies.import');
    Route::resource('companies', CompanyController::class);

    Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::get('/employees/onboarding/skip', [EmployeeController::class, 'skipOnboarding'])->name('employees.onboarding.skip');
    Route::resource('employees', EmployeeController::class);

    Route::post('/leavetypes/import', [LeaveTypeController::class, 'import'])->name('leavetypes.import');
    Route::resource('leavetypes', LeaveTypeController::class);

    Route::post('/leaves/import', [LeaveController::class, 'import'])->name('leaves.import');
    Route::resource('leaves', LeaveController::class)->parameters(['leaves' => 'leave']);
});

require __DIR__.'/auth.php';
