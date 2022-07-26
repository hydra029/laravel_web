<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('roles', static function (Blueprint $table) {
			$table->unsignedBigInteger('id');
			$table->unsignedBigInteger('dept_id');
			$table->string('name');
            $table->integer('pay_rate');
			$table->softDeletes();
            $table->primary(['id','dept_id']);
            $table->unique(['dept_id', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('roles');
	}
}
