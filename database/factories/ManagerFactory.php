<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManagerFactory extends Factory
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
	        'dept_id' => $this->faker->unique()->numberBetween(1, 10),
	        'role_id' => 1,
        ];
    }
}
