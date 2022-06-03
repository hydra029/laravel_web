<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array
	{
		$date = date_format(date_create(), 'Y-m-d');
		return [

			'date' => $date,
			'emp_id' => $this->faker->numberBetween(1, 10),
			'emp_role' => $this->faker->numberBetween(1, 4),
			'shift' => $this->faker->numberBetween(1, 3),
			'check_in' => $this->faker->numberBetween(0, 1),
			'check_out' => $this->faker->numberBetween(0, 1),
		];
	}
}
