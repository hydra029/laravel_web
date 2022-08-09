<?php

use App\Models\Fines;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('fines', static function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->integer('fines');
			$table->integer('deduction');
		});
		Fines::insert(
			[
				[
						'name' => 'Late 1',
						'fines' => 15,
						'deduction' => 15000,
				],
				[
						'name' => 'Late 2',
						'fines' => 30,
						'deduction' => 30000,
				],
				[
						'name' => 'Early 1',
						'fines' => 15,
						'deduction' => 15000,
				],
				[
						'name' => 'Early 1',
						'fines' => 30,
						'deduction' => 30000,
				],
				[
						'name' => 'Miss',
						'fines' => 0,
						'deduction' => 50000,
				],
			]
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('fines');
	}
}
