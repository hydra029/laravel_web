<?php

namespace App\Console;

use App\Enums\ShiftStatusEnum;
use App\Models\Accountant;
use App\Models\Attendance_shift_time;
use App\Models\Ceo;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule): void
	{
		$shifts = Attendance_shift_time::get();
		foreach ($shifts as $shift) {
			$schedule->call(function () use ($shift) {
				$users = Employee::query()->get('id');
				foreach ($users as $each) {
					$emp = array('emp_id' => $each->id, 'date' => date('Y-m-d'), 'shift' => $shift->id, 'emp_role' => 1);
					DB::table('attendances')->insert($emp);
				}
				$users = Manager::query()->get('id');
				foreach ($users as $each) {
					$mgr = array('emp_id' => $each->id, 'date' => date('Y-m-d'), 'shift' => $shift->id, 'emp_role' => 2);
					DB::table('attendances')->insert($mgr);
				}
				$users = Accountant::query()->get('id');
				foreach ($users as $each) {
					$acct = array('emp_id' => $each->id, 'date' => date('Y-m-d'), 'shift' => $shift->id, 'emp_role' => 3);
					DB::table('attendances')->insert($acct);
				}
			})->dailyAt('10:05');

			$check_in_start = date('H:i', strtotime($shift->check_in_start));
			$check_in_end = date('H:i', strtotime($shift->check_in_end));
			$check_out_start = date('H:i', strtotime($shift->check_out_start));
			$check_out_end = date('H:i', strtotime($shift->check_out_end));
			$shift_id = $shift->id;
			$schedule->call(function () use ($shift_id) {
				Attendance_shift_time::where('id', '=', $shift_id)
					->update(['status' => ShiftStatusEnum::Active]);
			})->dailyAt($check_in_start);
			$schedule->call(function () use ($shift_id) {
				Attendance_shift_time::where('id', '=', $shift_id)
					->update(['status' => ShiftStatusEnum::TimeOut]);
			})->dailyAt($check_in_end);
			$schedule->call(function () use ($shift_id) {
				Attendance_shift_time::where('id', '=', $shift_id)
					->update(['status' => ShiftStatusEnum::Active]);
			})->dailyAt($check_out_start);
			$schedule->call(function () use ($shift_id) {
				Attendance_shift_time::where('id', '=', $shift_id)
					->update(['status' => ShiftStatusEnum::TimeOut]);
			})->dailyAt($check_out_end);
		}
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected
	function commands(): void
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
