<?php

namespace App\Console;

use App\Enums\ShiftStatusEnum;
use App\Models\Accountant;
use App\Models\Attendance;
use App\Models\AttendanceShiftTime;
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

    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $shifts = AttendanceShiftTime::get();
        foreach ($shifts as $shift) {
            $schedule->call(function () use ($shift) {
                $arr = [];
                $users = Employee::whereStatus('1')->get('id');
                foreach ($users as $each) {
                    $emp = [
                        'emp_id' => $each->id,
                        'date' => date('Y-m-d'),
                        'shift' => $shift->id,
                        'emp_role' => 1
                    ];
                    $arr[] = $emp;
                }
                $users = Manager::whereStatus('1')->get('id');
                foreach ($users as $each) {
                    $mgr = [
                        'emp_id' => $each->id,
                        'date' => date('Y-m-d'),
                        'shift' => $shift->id,
                        'emp_role' => 2
                    ];
                    $arr[] = $mgr;
                }
                $users = Accountant::whereStatus('1')->get('id');
                foreach ($users as $each) {
                    $acct = [
                        'emp_id' => $each->id,
                        'date' => date('Y-m-d'),
                        'shift' => $shift->id,
                        'emp_role' => 3,
                    ];
                    $arr[] = $acct;
                }
                Attendance::insert($arr);
            })->days([1, 2, 3, 4, 5, 6])->daily();
        }
        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 1)
                ->update(['status' => ShiftStatusEnum::ACTIVE]);
        })->dailyAt('06:00');
        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 1)
                ->update(['status' => ShiftStatusEnum::TIME_OUT]);
        })->dailyAt('12:00');

        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 2)
                ->update(['status' => ShiftStatusEnum::ACTIVE]);
        })->dailyAt('12:00');
        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 2)
                ->update(['status' => ShiftStatusEnum::TIME_OUT]);
        })->dailyAt('19:00');

        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 3)
                ->update(['status' => ShiftStatusEnum::ACTIVE]);
        })->dailyAt('16:30');
        $schedule->call(function () {
            AttendanceShiftTime::where('id', '=', 3)
                ->update(['status' => ShiftStatusEnum::TIME_OUT]);
        })->dailyAt('23:30');

        $schedule->call(function () {
            AttendanceShiftTime::query()
                ->update(['status' => ShiftStatusEnum::INACTIVE]);
        })->daily();
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
