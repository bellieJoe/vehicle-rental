<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const TYPE_RENTAL = 'rental';
    const TYPE_DOOR_TO_DOOR = 'door_to_door';
    

    public function vehicleCategory()
    {
        return $this->belongsTo(VehicleCategory::class);
    }
}
