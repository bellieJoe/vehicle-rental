<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    // Define possible statuses for Vehicle Rental bookings
    const STATUS_PENDING = 'Pending';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_TO_PAY = 'To Pay';
    const STATUS_BOOKED = 'Booked';
    const STATUS_FOR_PICKUP = 'For Pickup';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CANCELLED = 'Cancelled';

    protected $guarded = [];

    protected $dates = ['start_date'];

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

    public function package(){
        return $this->belongsTo(Package::class);
    }

    
    public function bookingLogs(){
        return $this->hasMany(BookingLog::class)
            ->orderBy('created_at', 'DESC');
    }

    public function payments(){
        return $this->hasMany(Payment::class)
            ->orderBy('payment_exp', 'ASC');

    }


}
