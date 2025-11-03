<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    //
    use hasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
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


    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(VehicleCountry::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id'); // Explicit foreign key, not sure why it messes up without it
    }

}
