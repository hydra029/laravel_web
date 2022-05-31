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
	        'email' => $this->faker->email,
	        'password' => $this->faker->password,
	        'dept_id' => $this->faker->numberBetween(2, 20),
	        'role_id' => $this->faker->numberBetween(2, 20),
	        'status' => $this->faker->boolean,
        ];
    }
}
