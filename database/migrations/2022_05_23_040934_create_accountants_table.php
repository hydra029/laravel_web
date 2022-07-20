<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('accountants', static function (Blueprint $table) {
			$table->id();
			$table->string('fname');
			$table->string('lname');
			$table->boolean('gender');
			$table->timestamp('dob');
            $table->string('avatar')->nullable();
            $table->string('city');
            $table->string('district');
			$table->string('phone');
			$table->string('email');
			$table->string('password')->nullable();
			$table->unsignedBigInteger('dept_id')->default('1');
			$table->unsignedBigInteger('role_id');
			$table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('accountants');
	}
}
