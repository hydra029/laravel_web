<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\ApiController;
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
Route::post('/test/get_salary', [HomeController::class, 'getSalary'])->name('get_salary');
Route::post('/test/salary_detail', [HomeController::class, 'salaryDetail'])->name('salary_detail');

Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('login');
Route::get('/personal_information', [ApiController::class, 'personalInformation'])->name('personal_information');
Route::post('/', [LoginController::class, 'processLogin'])->name('process_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'employees', 'as' => 'employees.', 'middleware' => 'employee'], static function () {
	Route::post('/checkin', [EmployeeController::class, 'checkin'])->name('checkin');
	Route::post('/checkout', [EmployeeController::class, 'checkout'])->name('checkout');
	Route::get('/attendance_history', [EmployeeController::class, 'attendanceHistory'])->name('attendance_history');
	Route::post('/history_api', [ApiController::class, 'historyApi'])->name('history_api');
	Route::get('/salary', [EmployeeController::class, 'salary'])->name('salary');
	Route::post('/salary_detail', [EmployeeController::class, 'salaryDetail'])->name('salary_detail');
	Route::post('/confirm_salary', [EmployeeController::class, 'confirmSalary'])->name('confirm_salary');
	Route::get('/get_shift_time', [ApiController::class, 'getShiftTimes'])->name('get_shift_time');
	Route::post('get_personal_salary', [ApiController::class, 'getPersonalSalary'])->name('get_personal_salary');
	Route::get('personal_information', [ApiController::class, 'personalInformation'])->name('personal_information');
	Route::post('/update_information', [ApiController::class, 'updateInformation'])->name('update_information');
});

Route::group(['prefix' => 'managers', 'as' => 'managers.', 'middleware' => 'manager'], static function () {
	Route::post('/add', [ManagerController::class, 'add'])->name('add');
	Route::post('/checkin', [ManagerController::class, 'checkin'])->name('checkin');
	Route::post('/checkout', [ManagerController::class, 'checkout'])->name('checkout');
	Route::get('/today_attendance', [ManagerController::class, 'todayAttendance'])->name('today_attendance');
	Route::get('/attendance_history', [ManagerController::class, 'attendanceHistory'])->name('attendance_history');
	Route::get('/employee_attendance', [ManagerController::class, 'employeeAttendance'])->name('employee_attendance');
	Route::post('/history_api', [ManagerController::class, 'historyApi'])->name('history_api');
	Route::post('/attendance_api', [ManagerController::class, 'attendanceApi'])->name('attendance_api');
	Route::post('/emp_attendance_api', [ManagerController::class, 'empAttendanceApi'])->name('emp_attendance_api');
	Route::post('/salary_api', [ManagerController::class, 'salaryApi'])->name('salary_api');
	Route::get('/salary', [ManagerController::class, 'salary'])->name('salary');
	Route::get('/employee_salary', [ManagerController::class, 'employeeSalary'])->name('employee_salary');
	Route::post('/get_salary', [ManagerController::class, 'getSalary'])->name('get_salary');
	Route::post('/personal_salary', [ManagerController::class, 'personalSalary'])->name('personal_salary');
	Route::post('/sign_salary', [ManagerController::class, 'signSalary'])->name('sign_salary');
	Route::post('/salary_detail', [ManagerController::class, 'salaryDetail'])->name('salary_detail');
	Route::get('/department_api', [ManagerController::class, 'departmentApi'])->name('department_api');
	Route::get('/get_shift_time', [ApiController::class, 'getShiftTimes'])->name('get_shift_time');
	Route::post('/get_personal_salary', [ApiController::class, 'getPersonalSalary'])->name('get_personal_salary');
	Route::get('/personal_information', [ApiController::class, 'personalInformation'])->name('personal_information');
	Route::post('/confirm_salary', [EmployeeController::class, 'confirmSalary'])->name('confirm_salary');
	Route::post('/update_information', [ApiController::class, 'updateInformation'])->name('update_information');
	Route::group(['middleware' => 'mgr_acct'], static function () {
		Route::get('/sign_employee_salary', [ManagerController::class, 'signEmployeeSalary'])->name('sign_employee_salary');
		Route::post('/assign_accountant', [ManagerController::class, 'assignAccountant'])->name('assign_accountant');
		Route::get('/assignment', [ManagerController::class, 'assignment'])->name('assignment');
		Route::get('/accountant_api', [ManagerController::class, 'accountantApi'])->name('accountant_api');
	});
});

Route::group(['prefix' => 'accountants', 'as' => 'accountants.', 'middleware' => 'accountant'], static function () {
	Route::post('/checkin', [AccountantController::class, 'checkin'])->name('checkin');
	Route::post('/checkout', [AccountantController::class, 'checkout'])->name('checkout');
	Route::post('/test', [AccountantController::class, 'test'])->name('test');
	Route::post('/approve', [AccountantController::class, 'approve'])->name('approve');
	Route::get('/attendance_history', [AccountantController::class, 'attendanceHistory'])->name('attendance_history');
	Route::post('/history_api', [AccountantController::class, 'historyApi'])->name('history_api');
	Route::post('/attendance_api', [AccountantController::class, 'attendanceApi'])->name('attendance_api');
	Route::get('/salary', [AccountantController::class, 'salary'])->name('salary');
	Route::get('/employee_salary', [AccountantController::class, 'employeeSalary'])->name('employee_salary');
	Route::post('/get_salary', [AccountantController::class, 'getSalary'])->name('get_salary');
	Route::post('/approve', [AccountantController::class, 'approve'])->name('approve');
	Route::post('/salary_detail', [AccountantController::class, 'salaryDetail'])->name('salary_detail');
	Route::get('/department_api', [AccountantController::class, 'departmentApi'])->name('department_api');
	Route::get('/get_shift_time', [ApiController::class, 'getShiftTimes'])->name('get_shift_time');
	Route::post('get_personal_salary', [ApiController::class, 'getPersonalSalary'])->name('get_personal_salary');
	Route::get('/personal_information', [ApiController::class, 'personalInformation'])->name('personal_information');
	Route::post('/update_information', [ApiController::class, 'updateInformation'])->name('update_information');
});

Route::group(['prefix' => 'ceo', 'as' => 'ceo.', 'middleware' => 'ceo'], static function () {
	Route::get('/time', [CeoController::class, 'time'])->name('time');
	Route::post('/time_change/', [CeoController::class, 'timeChange'])->name('time_change');
	Route::get('/fines', [FinesController::class, 'index'])->name('fines');
	Route::post('/fines_store', [FinesController::class, 'store'])->name('fines_store');
	Route::post('/fines_update', [FinesController::class, 'update'])->name('fines_update');
	Route::post('/manager_name', [CeoController::class, 'managerName'])->name('manager_name');
	Route::get('/department', [DepartmentController::class, 'index'])->name('department');
	Route::get('/employee_salary', [CeoController::class, 'employeeSalary'])->name('employee_salary');
	Route::post('/get_salary', [SalaryController::class, 'getSalary'])->name('get_salary');
	Route::post('/salary_detail', [SalaryController::class, 'salaryDetail'])->name('salary_detail');
	Route::post('/sign_salary', [CeoController::class, 'signSalary'])->name('sign_salary');
	Route::get('/roles', [RoleController::class, 'index'])->name('roles');
	Route::post('/department_employees', [DepartmentController::class, 'departmentEmployees'])->name('department_employees');
	Route::post('/department_accountants', [DepartmentController::class, 'departmentAccountants'])->name('department_accountants');
	Route::get('/create_emp', [CeoController::class, 'createEmployee'])->name('create_emp');
	Route::post('/store_emp', [CeoController::class, 'storeEmployee'])->name('store_emp');
	Route::post('/store_acct', [CeoController::class, 'storeAccountant'])->name('store_acct');
	Route::post('/store_mgr', [CeoController::class, 'storeManager'])->name('store_mgr');
	Route::post('/select_role', [CeoController::class, 'selectRole'])->name('select_role');
	Route::post('/update_information', [ApiController::class, 'updateInformation'])->name('update_information');
	Route::delete('/delete_emp', [CeoController::class, 'deleteEmployee'])->name('delete_emp');
	Route::post('/employee_infor', [CeoController::class, 'employeeInformation'])->name('employee_infor');
	Route::post('/import_employee', [CeoController::class, 'importEmployee'])->name('import_employee');
	Route::post('/import_acct', [CeoController::class, 'importAccountant'])->name('import_acct');
	Route::post('/import_mgr', [CeoController::class, 'importManager'])->name('import_mgr');
	Route::get('/employee_attendance', [CeoController::class, 'employeeAttendance'])->name('employee_attendance');
	Route::post('/attendance_api', [CeoController::class, 'attendanceApi'])->name('attendance_api');
	Route::get('/department_api', [CeoController::class, 'departmentApi'])->name('department_api');
	Route::post('/emp_attendance_api', [CeoController::class, 'employeeAttendanceApi'])->name('emp_attendance_api');
	Route::get('/get_shift_time', [ApiController::class, 'getShiftTimes'])->name('get_shift_time');
	Route::post('get_personal_salary', [ApiController::class, 'getPersonalSalary'])->name('get_personal_salary');
	Route::get('/personal_information', [ApiController::class, 'personalInformation'])->name('personal_information');
	Route::get('/access_token', [CeoController::class, 'accessToken'])->name('access_token');
	Route::group(['prefix' => 'roles', 'as' => 'roles.'], static function () {
		Route::post('/store', [RoleController::class, 'store'])->name('store');
		Route::post('/update', [RoleController::class, 'update'])->name('update');
		Route::post('/destroy', [RoleController::class, 'destroy'])->name('destroy');
	});
	Route::group(['prefix' => 'department', 'as' => 'department.'], static function () {
		Route::post('/store', [DepartmentController::class, 'store'])->name('store');
		Route::post('/update', [DepartmentController::class, 'update'])->name('update');
		Route::post('/destroy', [DepartmentController::class, 'destroy'])->name('destroy');
		Route::post('/manager_role', [DepartmentController::class, 'managerRole'])->name('manager_role');
	});
});

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
