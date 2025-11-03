<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("api_identifier")->unique();
            $table->string('image_path')->nullable();
            $table->string("name");
            $table->integer("rank");
            $table->float("arcade_battle_rating");
            $table->float("realistic_battle_rating");
            $table->float("simulator_battle_rating");
            $table->integer("sl_price")->nullable();
            $table->integer("ge_price")->nullable();
            $table->boolean("is_premium")->default(false);
            $table->integer("research_points_requirement")->nullable();
            $table->foreignId("vehicle_country_id")->constrained("vehicle_countries");
            $table->foreignId("vehicle_type_id")->constrained("vehicle_types");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
