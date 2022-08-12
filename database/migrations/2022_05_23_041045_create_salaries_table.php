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
			$table->foreignId('emp_id')->constrained('employees');
			$table->unsignedTinyInteger('month');
			$table->integer('year');
			$table->string('dept_name');
			$table->string('role_name');
			$table->double('work_day',10,3);
			$table->double('over_work_day',10,3);
			$table->unsignedTinyInteger('late_1');
			$table->unsignedTinyInteger('late_2');
			$table->unsignedTinyInteger('early_1');
			$table->unsignedTinyInteger('early_2');
			$table->unsignedTinyInteger('miss');
			$table->unsignedInteger('pay_rate');
			$table->unsignedInteger('deduction');
			$table->unsignedInteger('salary');
			$table->foreignId('mgr_id')->constrained('managers');
			$table->foreignId('acct_id')->nullable()->constrained('accountants');
			$table->boolean('sign')->nullable();
			$table->primary(['emp_id', 'month', 'year','dept_name','role_name']);
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
