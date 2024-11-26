<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class D2dSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $dates = ["depart_date"];

    protected $cast = [
        "depart_date" => "datetime"
    ];

    public function d2dVehicle(){
        return $this->belongsTo(D2dVehicle::class);
    }

    public function route(){
        return $this->belongsTo(Route::class)->withTrashed();
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
    
}
