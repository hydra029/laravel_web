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
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 1; $j <= 8; $j++) {
                $unique[] = $i . '-' . $j;
            }
        }
        $unique = $this->faker->unique()->randomElement($unique);
        $unique = explode('-', $unique);
        [$id, $dept_id] = $unique;

        return [
            'id' => $id,
            'dept_id' => $dept_id,
            'name' => $this->faker->unique()->word,
            'pay_rate' => $this->faker->numberBetween(5000000, 20000000),
        ];
    }
}
