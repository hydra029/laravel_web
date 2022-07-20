<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CeoFactory extends Factory
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
	        'dob' => $this->faker->date(),
            'phone' => $this->faker->numerify('0#########'),
            'city' => $this->faker->city,
            'district' => $this->faker->streetName,
	        'email' => $this->faker->email,
        ];
    }
}
