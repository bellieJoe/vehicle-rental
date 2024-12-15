<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'start_datetime', 'valid_until', "cancelled_at", "return_in_time"
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'valid_until' => 'date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function additionalRate(){
        return $this->belongsTo(AdditionalRate::class);
    }

}
