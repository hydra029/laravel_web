<?php

namespace App\Console;

use App\Models\Employee;
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
		$schedule->call(function () {
			$users = Employee::query()->get('id');

			foreach ($users as $each) {
				$date = date_create();

				for ($i = 1; $i <= 3; $i++) {
					$data = array('emp_id' => $each->id, 'date' => $date, 'shift' => $i);
					DB::table('student_details')->insert($data);
				}
			}
		})->daily();
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands(): void
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
