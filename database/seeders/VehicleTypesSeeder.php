<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $types = [
            ["name" => "Tank", "slug" => "tank"],
            ["name" => "Light Tank", "slug" => "light_tank"],
            ["name" => "Medium Tank", "slug" => "medium_tank"],
            ["name" => "Heavy Tank", "slug" => "heavy_tank"],
            ["name" => "Tank Destroyer", "slug" => "tank_destroyer"],
            ["name" => "SPAA", "slug" => "spaa"],
            ["name" => "LBV", "slug" => "lbv"],
            ["name" => "MBV", "slug" => "mbv"],
            ["name" => "HBV", "slug" => "hbv"],
            ["name" => "Exoskeleton", "slug" => "exoskeleton"],
            ["name" => "Attack Helicopter", "slug" => "attack_helicopter"],
            ["name" => "Utility Helicopter", "slug" => "utility_helicopter"],
            ["name" => "Fighter", "slug" => "fighter"],
            ["name" => "Assault", "slug" => "assault"],
            ["name" => "Bomber", "slug" => "bomber"],
            ["name" => "Ship", "slug" => "ship"],
            ["name" => "Destroyer", "slug" => "destroyer"],
            ["name" => "Light Cruiser", "slug" => "light_cruiser"],
            ["name" => "Boat", "slug" => "boat"],
            ["name" => "Heavy Boat", "slug" => "heavy_boat"],
            ["name" => "Barge", "slug" => "barge"],
            ["name" => "Frigate", "slug" => "frigate"],
            ["name" => "Heavy Cruiser", "slug" => "heavy_cruiser"],
            ["name" => "Battlecruiser", "slug" => "battlecruiser"],
            ["name" => "Battleship", "slug" => "battleship"],
            ["name" => "Submarine", "slug" => "submarine"],
        ];


        foreach ($types as $type) {
            VehicleType::create($type);
        }
    }
}
