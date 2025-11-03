<?php

namespace Database\Seeders;

use App\Models\VehicleCountry;
use Illuminate\Database\Seeder;

class VehicleCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [
            "USA",
            "Sweden",
            "Germany",
            "Britain",
            "USSR",
            "China",
            "Japan",
            "France",
            "Israel",
            "Italy"
        ];

        foreach($countries as $country){
            VehicleCountry::create(["name" => $country, "slug" => strtolower($country)]);
        }
    }
}
