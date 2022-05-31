<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('ceos', static function (Blueprint $table) {
			$table->id();
			$table->string('fname');
			$table->string('lname');
			$table->boolean('gender');
			$table->timestamp('dob');
			$table->string('email');
			$table->string('password');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('ceos');
	}
}
