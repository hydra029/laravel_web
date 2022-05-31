<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayRatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('pay_rates', static function (Blueprint $table) {
			$table->unsignedBigInteger('dept_id');
			$table->unsignedBigInteger('role_id');
			$table->integer('pay_rate');
			$table->primary(['dept_id', 'role_id']);
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('pay_rates');
	}
}
