<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('attendances', static function (Blueprint $table) {
			$table->timestamp('date')->format('d-m-Y');
			$table->unsignedBigInteger('emp_id');
			$table->tinyInteger('shift');
			$table->boolean('check_in')->default(0);
			$table->boolean('check_out')->default(0);
			$table->primary(['emp_id', 'date', 'shift']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('attendances');
	}
}
