<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('salaries', static function (Blueprint $table) {
			$table->unsignedBigInteger('emp_id');
			$table->unsignedTinyInteger('month');
			$table->integer('year');
			$table->string('dept_name');
			$table->string('role_name');
			$table->unsignedTinyInteger('work_day');
			$table->unsignedInteger('pay_rate');
			$table->unsignedInteger('salary');
			$table->unsignedBigInteger('mgr_id');
			$table->unsignedBigInteger('acct_id');
			$table->boolean('ceo_sign');
			$table->boolean('status');
			$table->primary(['emp_id', 'month', 'year']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('salaries');
	}
}
