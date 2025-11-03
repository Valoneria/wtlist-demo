<?php

use App\Models\Vehicle;
use App\Models\VehicleCountry;
use App\Models\VehicleType;

it('has correct fillable attributes', function () {
    $fillable = [
        "api_identifier",
        "name",
        "rank",
        "arcade_battle_rating",
        "realistic_battle_rating",
        "simulator_battle_rating",
        "sl_price",
        "ge_price",
        "is_premium",
        "research_points_requirement",
        "vehicle_type_id",
        "vehicle_country_id",
        "image_path"
    ];

    expect((new Vehicle())->getFillable())->toBe($fillable);
});

it('can be created with factory', function () {
    $vehicle = Vehicle::factory()->create();
    expect($vehicle)->toBeInstanceOf(Vehicle::class);
});

it('has a country relationship', function () {
    $vehicle = Vehicle::factory()->create();
    $vehicle->load('country'); // Ensure the relationship is loaded
    expect($vehicle->country)->toBeInstanceOf(VehicleCountry::class);
});

it('has a type relationship', function () {
    $vehicle = Vehicle::factory()->create();
    $vehicle->load('type'); // Ensure the relationship is loaded
    expect($vehicle->type)->toBeInstanceOf(VehicleType::class);
});
