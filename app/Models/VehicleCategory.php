<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, "vehicle_category_id", "id");
    }

    public function user() {
        return $this->belongsTo(User::class, "id", "user_id");
    }
}
