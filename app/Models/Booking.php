<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    // Define possible statuses for Vehicle Rental bookings
    const STATUS_PENDING_VEHICLE = 'Pending';
    const STATUS_REJECTED_VEHICLE = 'Rejected';
    const STATUS_TO_PAY_VEHICLE = 'To Pay';
    const STATUS_COMPLETED_VEHICLE = 'Completed';
    const STATUS_CANCELLED_VEHICLE = 'Cancelled';
    
    // Define possible statuses for Package bookings
    const STATUS_PENDING_PACKAGE = 'Pending';
    const STATUS_REJECTED_PACKAGE = 'Rejected';
    const STATUS_TO_PAY_PACKAGE = 'To Pay';
    const STATUS_BOOKED_PACKAGE = 'Booked'; // More statuses specific to packages
    const STATUS_COMPLETED_PACKAGE = 'Completed';
    const STATUS_CANCELLED_PACKAGE = 'Cancelled';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function bookingDetail(){
        return $this->hasOne(BookingDetail::class);
    }


}
