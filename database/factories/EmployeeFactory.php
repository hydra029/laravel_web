<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
	        'fname' => $this->faker->firstName,
	        'lname' => $this->faker->lastName,
	        'gender' => $this->faker->boolean,
	        'dob' => $this->faker->dateTimeBetween(),
            'phone' => $this->faker->numerify('0#########'),
            'city' => $this->faker->city,
            'district' => $this->faker->streetName,
	        'email' => $this->faker->email,
	        'dept_id' => $this->faker->numberBetween(2, 10),
	        'role_id' => $this->faker->numberBetween(2, 10),
	        'status' => $this->faker->boolean,
        ];
    }
}
