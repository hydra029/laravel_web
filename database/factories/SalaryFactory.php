<?php

namespace Database\Factories;

use App\Models\Accountant;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */

	public function definition(): array
	{
		for ($i = 2020; $i <= 2022; $i++) {
			for ($j = 1; $j <= 12; $j++) {
				for ($q = 1; $q <= 10; $q++) {
					$unique[] = $i . '-' . $j . '-' . $q;
				}
			}
		}

		$unique = $this->faker->unique()->randomElement($unique);

		$unique = explode('-', $unique);
		$year = (int)$unique[0];
		$month = (int)$unique[1];
		$emp_id = (int)$unique[2];

		return
			[
			'emp_id' => $emp_id,
			'month' => $month,
			'year' => $year,
			'dept_name' => $this->faker->word,
			'role_name' => $this->faker->word,
			'work_day' => $this->faker->numberBetween(20, 30),
			'pay_rate' => $this->faker->numberBetween(5000000, 20000000),
			'salary' => $this->faker->numberBetween(8000000, 40000000),
			'mgr_id' => $this->faker->numberBetween(1, 10),
			'acct_id' => $this->faker->numberBetween(1, 5),
			'ceo_sign' => $this->faker->boolean,
			'status' => $this->faker->boolean,
		];
	}
}
