<?php


namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
   
    public function definition(): array
    {
        $name = $this->faker->name();
        return [
            'title' => $name,
            'slug' => str($name)->slug(),
            'description' => $this->faker->paragraph(1),
            'text' => $this->faker->paragraph(4),
            'category_id' => $this->faker->randomElement([1,2,3]),
            'posted' => $this->faker->randomElement(['yes','not']),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
