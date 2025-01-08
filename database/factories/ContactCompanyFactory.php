<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactCompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'identification' => $this->faker->sentence,
            'email' => $this->faker->email,
            'extra' => $this->faker->sentence,
            'choices' => $this->faker->randomElement(['advert', 'post', 'course', 'movie', 'other']),
            'contact_general_id' => 1,
        ];
    }
}
