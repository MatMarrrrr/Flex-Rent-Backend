<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    public function definition(): array
    {
        $images = [
            'https://i.imgur.com/UkehWwJ.png',
            'https://i.imgur.com/RwY4ieS.jpeg',
            'https://i.imgur.com/iPMFXGq.jpeg',
        ];

        return [
            'owner_id' => 1,
            'category_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->randomElement($images),
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'currency' => $this->faker->randomElement(['USD', 'PLN']),
            'localization' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
