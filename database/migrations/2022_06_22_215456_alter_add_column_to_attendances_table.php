<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('attendances', static function (Blueprint $table) {
	        $table->time('check_in')->change();
	        $table->time('check_out')->change();
	        $table->unsignedTinyInteger('check_in_status')->after('check_out');
	        $table->unsignedTinyInteger('check_out_status')->after('check_in_status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('attendances', static function (Blueprint $table) {
	        $table->dropColumn('check_in');
	        $table->dropColumn('check_out');
	        $table->dropColumn('check_in_status');
	        $table->dropColumn('check_out_status');

        });
    }
}
