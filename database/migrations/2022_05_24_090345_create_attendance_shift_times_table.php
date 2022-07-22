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
            $table->time('check_in_start')->default('00:00:00');
            $table->time('check_in_end')->default('00:00:00');
            $table->time('check_in_late_1')->default('00:00:00');
            $table->time('check_in_late_2')->default('00:00:00');
            $table->time('check_out_early_1')->default('00:00:00');
            $table->time('check_out_early_2')->default('00:00:00');
            $table->time('check_out_start')->default('00:00:00');
            $table->time('check_out_end')->default('00:00:00');
            $table->unsignedTinyInteger('status')->default('1');
        });
        AttendanceShiftTime::insert([['id' => 1],['id' => 2],['id' => 3]]);
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
