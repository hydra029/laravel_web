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
	    Schema::table('employees', static function($table) {
		    $table->foreign('dept_id')->references('id')->on('departments');
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
	    });
	    Schema::table('employee_changes', static function($table) {
		    $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
	    });
	    Schema::table('salaries', static function ($table) {
		    $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
		    $table->foreign('mgr_id')->references('id')->on('managers')->onDelete('cascade');
		    $table->foreign('acct_id')->references('id')->on('accountants')->onDelete('cascade');
	    });
	    Schema::table('managers', static function($table) {
		    $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
	    });
	    Schema::table('accountants', static function($table) {
		    $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
	    });
	    Schema::table('roles', static function($table) {
		    $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
	    });
	    Schema::table('attendances', static function ($table) {
		    $table->foreign('shift')->references('id')->on('attendance_shift_times')->onDelete('cascade');
	    });

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
