<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'owner_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => 'Villa',
            'listing_category' => 'buy',
            'location' => $this->faker->city,
            'price' => $this->faker->numberBetween(1000000, 10000000),
            'images' => [],
            'metadata' => ['amenities' => ['pool', 'gym']],
            'status' => PropertyStatus::ACTIVE,
            'bhk_count' => 3,
            'total_area' => 120.00,
            'is_featured' => false,
        ];
    }
}
