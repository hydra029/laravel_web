<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CeoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
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

Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('login');
Route::post('/', [LoginController::class, 'processLogin'])->name('process_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::put('/employees/checkin', [EmployeeController::class, 'checkin'])->name('employees.checkin');
Route::put('/employees/checkout', [EmployeeController::class, 'checkout'])->name('employees.checkout');
Route::put('/managers/checkin', [EmployeeController::class, 'checkin'])->name('managers.checkin');
Route::put('/managers/checkout', [EmployeeController::class, 'checkout'])->name('managers.checkout');
Route::put('/accountants/checkin', [EmployeeController::class, 'checkin'])->name('accountants.checkin');
Route::put('/accountants/checkout', [EmployeeController::class, 'checkout'])->name('accountants.checkout');
Route::get('/ceo/time', [CeoController::class, 'time'])->name('ceo.time');
Route::post('/ceo/time_change/', [CeoController::class, 'time_change'])->name('ceo.time_change');


Route::resource('employees', EmployeeController::class)->except([
	'show',
]);

Route::resource('accountants', AccountantController::class)->except([
	'show',
]);

Route::resource('managers', ManagerController::class)->except([
	'show',

]);
Route::resource('ceo', CeoController::class)->except([
	'show',
]);
