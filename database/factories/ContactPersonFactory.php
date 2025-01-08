<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'surname' => $this->faker->sentence,
            'other' => $this->faker->sentence,
            'choices' => $this->faker->randomElement(['advert', 'post', 'course', 'movie', 'other']),
            'contact_general_id' => 1,
        ];
    }
}
