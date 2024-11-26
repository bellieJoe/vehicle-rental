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
    // const STATUS_FOR_PICKUP = 'For Pickup';
    // const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CANCELLED = 'Cancelled';

    const TYPE_VEHICLE = 'Vehicle';
    const TYPE_PACKAGE = 'Package';
    const TYPE_DOOR_TO_DOOR = 'Door to Door';

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

    public function d2dSchedule(){
        return $this->belongsTo(D2dSchedule::class);
    }

    
    public function bookingLogs(){
        return $this->hasMany(BookingLog::class)
            ->orderBy('created_at', 'DESC');
    }

    public function payments(){
        return $this->hasMany(Payment::class)
            ->orderBy('payment_exp', 'ASC');

    }

    public function refunds() {
        return $this->hasMany(Refund::class);
    }

    public function canBeCompleted() {
        $end_datetime = null;
        if($this->booking_type == "Vehicle"){
            $end_datetime = $this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days);
        }
        else if($this->booking_type == "Package"){
            $end_datetime = $this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days)->subHours(9);
        }
        else if($this->booking_type == "Door to Door"){
            $end_datetime = $this->d2dSchedule->depart_date->addDays(1);
        }

        if(!$end_datetime) {
            return false;
        }

        if($this->status != self::STATUS_BOOKED) {
            return false;
        }

        if($this->payments->where("payment_status", Payment::STATUS_PAID)->sum("amount") < $this->computed_price) {
            return false;
        }
        
        return $end_datetime->isPast();
    }

    public function getAmountPaid(){
        return $this->payments->where("payment_status", Payment::STATUS_PAID)->sum("amount");
    }

    public function feedback(){
        return $this->hasOne(Feedback::class);
    }

}
