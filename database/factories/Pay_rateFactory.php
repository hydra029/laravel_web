<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Pay_rateFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array
	{
		for ($i = 1; $i <= 10; $i++) {
			for ($j = 1; $j <= 10; $j++) {
				$unique[] = $i . '-' . $j;
			}
		}

		$unique = $this->faker->unique()->randomElement($unique);

		$unique = explode('-', $unique);
		$dept_id = (int)$unique[0];
		$role_id = (int)$unique[1];
		return [
			'dept_id' => $dept_id,
			'role_id' => $role_id,
			'pay_rate' => $this->faker->numberBetween(5000000, 20000000),
		];
	}
}
