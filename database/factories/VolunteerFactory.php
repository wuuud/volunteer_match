<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class VolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // API前
        return [
            'user_id' => User::factory(),
            // 'career' => $this->faker->realText,
        ];
    }
}
