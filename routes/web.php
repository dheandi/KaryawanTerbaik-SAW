<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SawController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Criteria
    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria.index');
    Route::get('/criteria/{criterion}', [CriteriaController::class, 'show'])->name('criteria.show');
    Route::post('/criteria', [CriteriaController::class, 'store'])->name('criteria.store');
    Route::put('/criteria/{criterion}', [CriteriaController::class, 'update'])->name('criteria.update');
    Route::delete('/criteria/{criterion}', [CriteriaController::class, 'destroy'])->name('criteria.destroy');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // Scores
    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');

    // SAW
    Route::get('/saw', [SawController::class, 'index'])->name('saw.index');
});
