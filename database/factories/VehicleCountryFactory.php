<?php

namespace Database\Factories;

use App\Models\VehicleCountry;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleCountryFactory extends Factory
{
    protected $model = VehicleCountry::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country(),
            'slug' => $this->faker->unique()->slug(),
        ];
    }
}
