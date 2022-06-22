<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnToAttendanceShiftTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('attendance_shift_times', static function (Blueprint $table) {
	        $table->time('check_in_late_1')->after('check_in_end');
	        $table->time('check_in_late_2')->after('check_in_late_1');
	        $table->time('check_out_early_1')->after('check_in_late_2');
	        $table->time('check_out_early_2')->after('check_out_early_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('attendance_shift_times', static function (Blueprint $table) {
	        $table->dropColumn('check_in_late_1');
	        $table->dropColumn('check_in_late_2');
	        $table->dropColumn('check_out_early_1');
	        $table->dropColumn('check_out_early_2');
        });
    }
}
