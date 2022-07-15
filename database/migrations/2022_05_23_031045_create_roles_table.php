<?php

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
			$table->id();
			$table->foreignId('dept_id')->constrained('departments')->onDelete('cascade');
			$table->integer('pay_rate');
			$table->string('name');
			$table->boolean('status');
			$table->primary(['id', 'dept_id']);
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
