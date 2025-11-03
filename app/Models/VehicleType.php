<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug']; // Fields allowed for mass assignment

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
