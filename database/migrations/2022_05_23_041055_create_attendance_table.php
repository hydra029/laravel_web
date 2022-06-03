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
			$table->date('date');
			$table->unsignedBigInteger('emp_id');
			$table->unsignedTinyInteger('emp_role')->default(1);
			$table->unsignedtinyInteger('shift');
			$table->unsignedTinyInteger('status')->default(1);
			$table->boolean('check_in')->default(0);
			$table->boolean('check_out')->default(0);
			$table->primary(['emp_id', 'date', 'shift', 'emp_role']);
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
