<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CeoController;
use App\Http\Controllers\DepartmentController;
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
Route::put('/managers/checkin', [ManagerController::class, 'checkin'])->name('managers.checkin');
Route::put('/managers/checkout', [ManagerController::class, 'checkout'])->name('managers.checkout');
Route::get('/managers/attendance', [ManagerController::class, 'attendance'])->name('managers.attendance');
Route::put('/accountants/checkin', [AccountantController::class, 'checkin'])->name('accountants.checkin');
Route::put('/accountants/checkout', [AccountantController::class, 'checkout'])->name('accountants.checkout');
Route::get('/ceo/time', [CeoController::class, 'time'])->name('ceo.time');
Route::post('/ceo/time_change/', [CeoController::class, 'time_change'])->name('ceo.time_change');
// Pay Rate
Route::get('/ceo/pay_rate', [CeoController::class, 'pay_rate'])->name('ceo.pay_rate');
Route::post('/ceo/pay_rate_api', [CeoController::class, 'pay_rate_api'])->name('ceo.pay_rate_api');
Route::post('/ceo/pay_rate_change/', [CeoController::class, 'pay_rate_change'])->name('ceo.pay_rate_change');
Route::post('/ceo/manager_name', [CeoController::class, 'manager_name'])->name('ceo.manager_name');
// Department
Route::get('/ceo/department', [DepartmentController::class, 'index'])->name('ceo.department');
Route::post('/ceo/department_api', [DepartmentController::class, 'department_api'])->name('ceo.department_api');
Route::post('/ceo/department_count_employees', [DepartmentController::class, 'department_count_employees'])->name('ceo.department_count_employees');
Route::post('/ceo/department_employees', [DepartmentController::class, 'department_employees'])->name('ceo.department_employees');
Route::post('/ceo/department/store', [DepartmentController::class, 'store'])->name('ceo.department.store');
Route::post('/ceo/department/update', [DepartmentController::class, 'update'])->name('ceo.department.update');



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
