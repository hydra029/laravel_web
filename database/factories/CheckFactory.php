<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CheckFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array
	{
		return [
			'date' => $this->faker->date(),
			'emp_id' => $this->faker->numberBetween(1, 1000),
			'shift' => $this->faker->numberBetween(1, 3),
			'check_in' => $this->faker->numberBetween(0, 1),
			'check_out' => $this->faker->numberBetween(0, 1),
		];
	}
}
