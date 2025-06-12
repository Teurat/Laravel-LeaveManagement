<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveTypeController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('/dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('companies', CompanyController::class);
Route::post('/companies/import', [CompanyController::class, 'import'])->name('companies.import');

Route::resource('employees', EmployeeController::class);
Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import');


Route::resource('leavetypes', LeaveTypeController::class);
Route::post('/leavetypes/import', [LeaveTypeController::class, 'import'])->name('leavetypes.import');

Route::resource('leaves', LeaveController::class)->parameters([
    'leaves' => 'leave'
]);
Route::post('/leaves/import', [LeaveController::class, 'import'])->name('leaves.import');


require __DIR__.'/auth.php';
