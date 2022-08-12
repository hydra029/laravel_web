<?php

use App\Models\Department;
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
			$table->foreignId('dept_id')->constrained('departments')->default(1);
			$table->foreignId('role_id')->constrained('roles');
            $table->timestamps();
            $table->softDeletes();
		});
		Department::foreign('acct_id')->references('id')->on('accountants');
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
