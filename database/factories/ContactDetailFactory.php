<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class ContactDetailFactory extends Factory
{

    public function definition(): array
    {
        return [
            'extra' => $this->faker->sentence,
            'contact_general_id' => 1,
        ];
    }
}
