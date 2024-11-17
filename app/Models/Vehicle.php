<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function vehicleCategory (){
        return $this->belongsTo(VehicleCategory::class);
    }

    public function user (){
        return $this->belongsTo(User::class, "id", "user_id");
    }
}

