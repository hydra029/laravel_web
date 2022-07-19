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
			$table->unsignedInteger('deduction');
			$table->unsignedInteger('salary');
			$table->unsignedBigInteger('mgr_id');
			$table->unsignedBigInteger('acct_id')->nullable();
			$table->boolean('ceo_sign')->nullable();
			$table->boolean('status')->default(1);
			$table->primary(['emp_id', 'month', 'year']);
            $table->timestamps();
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
