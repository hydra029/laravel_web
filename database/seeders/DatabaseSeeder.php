<?php

namespace Database\Seeders;

use App\Models\Accountant;
use App\Models\Ceo;
use App\Models\Check;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Pay_rate;
use App\Models\Role;
use App\Models\Salary;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(): void
	{
		$this->call([
			Department::factory(20)
				->create(),
			Role::factory(20)
				->create(),
			Pay_rate::factory(100)
				->create(),
			Employee::factory(1000)
				->create(),
			Accountant::factory(50)
				->create(),
			Ceo::factory(1)
				->create(),
			Manager::factory(20)
				->create(),
			Check::factory(100)
				->create(),
			Salary::factory(1000)
				->create(),
		]);
	}
}
