<?php

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
	        $table->time('check_out_start');
	        $table->time('check_out_end');
	        $table->unsignedTinyInteger('status');
        });
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
