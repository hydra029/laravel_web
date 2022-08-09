<?php

use App\Models\AttendanceShiftTime;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceShiftTimesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('attendance_shift_times', static function (Blueprint $table) {
			$table->id();
			$table->time('check_in_start');
			$table->time('check_in_end');
			$table->time('check_in_late_1');
			$table->time('check_in_late_2');
			$table->time('check_out_early_1');
			$table->time('check_out_early_2');
			$table->time('check_out_start');
			$table->time('check_out_end');
		});
		AttendanceShiftTime::query()
			->insert(
				[
					[
						'id'                => 1,
						'check_in_start'    => '07:00:00',
						'check_in_end'      => '07:30:00',
						'check_in_late_1'   => '07:45:00',
						'check_in_late_2'   => '08:00:00',
						'check_out_early_1' => '11:00:00',
						'check_out_early_2' => '11:15:00',
						'check_out_start'   => '11:30:00',
						'check_out_end'     => '12:00:00',
					],
					[
						'id'                => 2,
						'check_in_start'    => '13:30:00',
						'check_in_end'      => '14:00:00',
						'check_in_late_1'   => '14:15:00',
						'check_in_late_2'   => '14:30:00',
						'check_out_early_1' => '17:30:00',
						'check_out_early_2' => '17:45:00',
						'check_out_start'   => '18:00:00',
						'check_out_end'     => '18:30:00',
					],
					[
						'id'                => 3,
						'check_in_start'    => '17:30:00',
						'check_in_end'      => '18:00:00',
						'check_in_late_1'   => '18:15:00',
						'check_in_late_2'   => '18:30:00',
						'check_out_early_1' => '21:00:00',
						'check_out_early_2' => '21:15:00',
						'check_out_start'   => '21:30:00',
						'check_out_end'     => '22:00:00',
					]
				]
			);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('attendance_shift_times');
	}
}
