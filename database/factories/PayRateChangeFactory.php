<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PayRateChangeFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array
	{
		return [
			'dept_id' => $this->faker->numberBetween(1, 20),
			'role_id' => $this->faker->numberBetween(1, 20),
			'pay_rate' => $this->faker->numberBetween(5000000, 20000000),
		];
	}
}
