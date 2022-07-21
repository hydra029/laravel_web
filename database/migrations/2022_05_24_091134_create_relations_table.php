<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
//		Schema::table('employees', static function ($table) {
//			$table->foreignId('dept_id')->constrained('departments');
//			$table->foreignId('role_id')->constrained('roles');
//		});
//
//		Schema::table('salaries', static function ($table) {
//			$table->foreignId('emp_id')->constrained('employees');
//			$table->foreignId('mgr_id')->constrained('managers');
//			$table->foreignId('acct_id')->constrained('accountants');
//		});
//		Schema::table('managers', static function ($table) {
//			$table->foreignId('dept_id')->constrained('departments');
//			$table->foreignId('role_id')->constrained('roles');
//		});
//		Schema::table('accountants', static function ($table) {
//			$table->foreignId('dept_id')->constrained('departments');
//			$table->foreignId('role_id')->constrained('roles');
//		});
//		Schema::table('attendances', static function ($table) {
//			$table->foreignId('shift')->constrained('attendance_shift_times');
//		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('relations');
	}
}
