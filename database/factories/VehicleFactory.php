<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\VehicleCountry;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'api_identifier' => $this->faker->unique()->word(),
            'name' => $this->faker->word(),
            'rank' => $this->faker->numberBetween(1, 10),
            'arcade_battle_rating' => $this->faker->randomFloat(1, 1, 10),
            'realistic_battle_rating' => $this->faker->randomFloat(1, 1, 10),
            'simulator_battle_rating' => $this->faker->randomFloat(1, 1, 10),
            'sl_price' => $this->faker->numberBetween(1000, 1000000),
            'ge_price' => $this->faker->numberBetween(1000, 1000000),
            'is_premium' => $this->faker->boolean(),
            'research_points_requirement' => $this->faker->numberBetween(1000, 1000000),
            'vehicle_type_id' => VehicleType::factory()->create()->id,
            'vehicle_country_id' => VehicleCountry::factory()->create()->id,
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
