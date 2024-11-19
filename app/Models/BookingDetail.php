<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'start_datetime' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
