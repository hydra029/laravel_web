<?php

use App\Enums\EmpRoleEnum;
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
			$table->unsignedTinyInteger('emp_role')->default(EmpRoleEnum::EMPLOYEE);
			$table->unsignedBigInteger('shift');
			$table->time('check_in')->default('00:00');
			$table->time('check_out')->default('00:00');
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
