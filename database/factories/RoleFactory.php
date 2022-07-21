<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'dept_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->unique()->word,
            'pay_rate' => $this->faker->numberBetween(5000000, 20000000),
            'status' => $this->faker->boolean,
        ];
    }
}
