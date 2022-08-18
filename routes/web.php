<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CeoController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::post('/test/get_salary', [HomeController::class, 'get_salary'])->name('get_salary');
Route::post('/test/salary_detail', [HomeController::class, 'salary_detail'])->name('salary_detail');

Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('login');
Route::post('/', [LoginController::class, 'processLogin'])->name('process_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/employees/checkin', [EmployeeController::class, 'checkin'])->name('employees.checkin');
Route::post('/employees/checkout', [EmployeeController::class, 'checkout'])->name('employees.checkout');
Route::get('/employees/attendance_history', [EmployeeController::class, 'attendance_history'])->name('employees.attendance_history');
Route::post('/employees/history_api', [EmployeeController::class, 'history_api'])->name('employees.history_api');
Route::post('/employees/salary', [EmployeeController::class, 'salary'])->name('employees.salary');
Route::post('/employees/salary_detail', [EmployeeController::class, 'salary_detail'])->name('employees.salary_detail');
Route::post('/employees/confirm_salary', [EmployeeController::class, 'confirm_salary'])->name('employees.confirm_salary');

Route::post('/managers/add', [ManagerController::class, 'add'])->name('managers.add');
Route::post('/managers/checkin', [ManagerController::class, 'checkin'])->name('managers.checkin');
Route::post('/managers/checkout', [ManagerController::class, 'checkout'])->name('managers.checkout');
Route::get('/managers/today_attendance', [ManagerController::class, 'today_attendance'])->name('managers.today_attendance');
Route::get('/managers/attendance_history', [ManagerController::class, 'attendance_history'])->name('managers.attendance_history');
Route::get('/managers/employee_attendance', [ManagerController::class, 'employee_attendance'])->name('managers.employee_attendance');
Route::post('/managers/history_api', [ManagerController::class, 'history_api'])->name('managers.history_api');
Route::post('/managers/attendance_api', [ManagerController::class, 'attendance_api'])->name('managers.attendance_api');
Route::post('/managers/emp_attendance_api', [ManagerController::class, 'emp_attendance_api'])->name('managers.emp_attendance_api');
Route::post('/managers/salary_api', [ManagerController::class, 'salary_api'])->name('managers.salary_api');
Route::get('/managers/salary', [ManagerController::class, 'salary'])->name('managers.salary');
Route::get('/managers/employee_salary', [ManagerController::class, 'employee_salary'])->name('managers.employee_salary');
Route::post('/managers/get_salary', [ManagerController::class, 'get_salary'])->name('managers.get_salary');
Route::post('/managers/personal_salary', [ManagerController::class, 'personal_salary'])->name('managers.personal_salary');
Route::post('/managers/sign_salary', [ManagerController::class, 'sign_salary'])->name('managers.sign_salary');
Route::post('/managers/salary_detail', [ManagerController::class, 'salary_detail'])->name('managers.salary_detail');
Route::get('/managers/department_api', [ManagerController::class, 'department_api'])->name('managers.department_api');
Route::get('/managers/assignment', [ManagerController::class, 'assignment'])->name('managers.assignment')->middleware('mgr_acct');
Route::get('/managers/accountant_api', [ManagerController::class, 'accountant_api'])->name('managers.accountant_api')->middleware('mgr_acct');
Route::post('/managers/assign_accountant', [ManagerController::class, 'assign_accountant'])->name('managers.assign_accountant')->middleware('mgr_acct');

Route::post('/accountants/checkin', [AccountantController::class, 'checkin'])->name('accountants.checkin');
Route::post('/accountants/checkout', [AccountantController::class, 'checkout'])->name('accountants.checkout');
Route::post('/accountants/test', [AccountantController::class, 'test'])->name('accountants.test');
Route::post('/accountants/approve', [AccountantController::class, 'approve'])->name('accountants.approve');
Route::get('/accountants/attendance_history', [AccountantController::class, 'attendance_history'])->name('accountants.attendance_history');
Route::post('/accountants/history_api', [AccountantController::class, 'history_api'])->name('accountants.history_api');
Route::post('/accountants/attendance_api', [AccountantController::class, 'attendance_api'])->name('accountants.attendance_api');
Route::get('/accountants/salary', [AccountantController::class, 'salary'])->name('accountants.salary');
Route::get('/accountants/employee_salary', [AccountantController::class, 'employee_salary'])->name('accountants.employee_salary');
Route::post('/accountants/get_salary', [AccountantController::class, 'get_salary'])->name('accountants.get_salary');
Route::post('/accountants/approve', [AccountantController::class, 'approve'])->name('accountants.approve');
Route::post('/accountants/salary_detail', [AccountantController::class, 'salary_detail'])->name('accountants.salary_detail');
Route::get('/accountants/department_api', [AccountantController::class, 'department_api'])->name('accountants.department_api');

Route::get('/ceo/time', [CeoController::class, 'time'])->name('ceo.time');
Route::post('/ceo/time_change/', [CeoController::class, 'time_change'])->name('ceo.time_change');
Route::get('/ceo/fines', [FinesController::class, 'index'])->name('ceo.fines');
Route::post('/ceo/fines_store', [FinesController::class, 'store'])->name('ceo.fines_store');
Route::post('/ceo/fines_update', [FinesController::class, 'update'])->name('ceo.fines_update');
Route::post('/ceo/manager_name', [CeoController::class, 'manager_name'])->name('ceo.manager_name');
Route::get('/ceo/department', [DepartmentController::class, 'index'])->name('ceo.department');

Route::get('/ceo/employee_salary', [CeoController::class, 'employee_salary'])->name('ceo.employee_salary');
Route::post('/ceo/get_salary', [SalaryController::class, 'get_salary'])->name('ceo.get_salary');
Route::post('/ceo/salary_detail', [SalaryController::class, 'salary_detail'])->name('ceo.salary_detail');
Route::post('/ceo/sign_salary', [CeoController::class, 'sign_salary'])->name('ceo.sign_salary');

Route::get('/ceo/roles', [RoleController::class, 'index'])->name('ceo.roles');
Route::post('/ceo/roles/store', [RoleController::class, 'store'])->name('ceo.roles.store');
Route::post('/ceo/roles/update', [RoleController::class, 'update'])->name('ceo.roles.update');
Route::post('/ceo/roles/destroy', [RoleController::class, 'destroy'])->name('ceo.roles.destroy');

Route::post('/ceo/department_employees', [DepartmentController::class, 'department_employees'])->name('ceo.department_employees');
Route::post('/ceo/department_accountants', [DepartmentController::class, 'department_accountants'])->name('ceo.department_accountants');
Route::post('/ceo/department/store', [DepartmentController::class, 'store'])->name('ceo.department.store');
Route::post('/ceo/department/update', [DepartmentController::class, 'update'])->name('ceo.department.update');
Route::post('/ceo/department/destroy', [DepartmentController::class, 'destroy'])->name('ceo.department.destroy');
Route::post('/ceo/department/manager_role', [DepartmentController::class, 'manager_role'])->name('ceo.department.manager_role');

Route::get('/ceo/create_emp', [CeoController::class, 'create_emp'])->name('ceo.create_emp');
Route::post('/ceo/store_emp', [CeoController::class, 'store_emp'])->name('ceo.store_emp');
Route::post('/ceo/store_acct', [CeoController::class, 'store_acct'])->name('ceo.store_acct');
Route::post('/ceo/store_mgr', [CeoController::class, 'store_mgr'])->name('ceo.store_mgr');
Route::post('/ceo/select_role', [CeoController::class, 'select_role'])->name('ceo.select_role');
Route::post('/ceo/update_emp', [CeoController::class, 'update_emp'])->name('ceo.update_emp');

Route::delete('/ceo/delete_emp/', [CeoController::class, 'delete_emp'])->name('ceo.delete_emp');
Route::post('/ceo/employee_infor', [CeoController::class, 'employee_infor'])->name('ceo.employee_infor');
Route::post('/ceo/import_employee', [CeoController::class, 'import_employee'])->name('ceo.import_employee');
Route::post('/ceo/import_acct', [CeoController::class, 'import_acct'])->name('ceo.import_acct');
Route::post('/ceo/import_mgr', [CeoController::class, 'import_mgr'])->name('ceo.import_mgr');
Route::get('/ceo/get_infor', [CeoController::class, 'get_infor'])->name('ceo.get_infor');

Route::get('/ceo/employee_attendance', [CeoController::class, 'employee_attendance'])->name('ceo.employee_attendance');
Route::post('/ceo/attendance_api', [CeoController::class, 'attendance_api'])->name('ceo.attendance_api');
Route::get('/ceo/department_api', [CeoController::class, 'department_api'])->name('ceo.department_api');
Route::post('/ceo/emp_attendance_api', [CeoController::class, 'emp_attendance_api'])->name('ceo.emp_attendance_api');

Route::resource('employees', EmployeeController::class)
	->except([
		         'show',
	         ]);
Route::resource('accountants', AccountantController::class)
	->except([
		         'show',
	         ]);
Route::resource('managers', ManagerController::class)
	->except([
		         'show',
	         ]);
Route::resource('ceo', CeoController::class)
	->except([
		         'show',
	         ]);
