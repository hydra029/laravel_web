<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CeoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('login');
Route::post('/', [LoginController::class, 'processLogin'])->name('process_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('employees', EmployeeController::class)->except([
	'show',
])->middleware('employee');

Route::resource('accountants', AccountantController::class)->except([
	'show',
])->middleware('accountant');
Route::resource('managers', ManagerController::class)->except([
	'show',
])->middleware('manager');
Route::resource('ceo', CeoController::class)->except([
	'show',
])->middleware('ceo');
