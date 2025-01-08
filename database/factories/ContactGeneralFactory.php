<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactGeneralFactory extends Factory
{


    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph(1),
            'type' => $this->faker->randomElement(['company', 'person']),
        ];
    }
}
