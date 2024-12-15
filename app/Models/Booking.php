<?php

namespace App\Models;

use Carbon\Carbon;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDO;

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

    //  additional status
    const STATUS_CANCEL_REQUESTED = 'Cancel Requested';
    const STATUS_CANCEL_APPROVED = 'Cancel Approved';
    const STATUS_CANCEL_REJECTED = 'Cancel Rejected';
    const STATUS_CANCEL_COMPLETED = 'Cancel Completed';

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

    public function cancellationDetail(){
        return $this->hasOne(CancellationDetail::class);
    }

    public function getRefundableAmount(){
        $orgUser = null;
        $start_date = null;
        if($this->booking_type == "Vehicle"){
            $orgUser = $this->vehicle->user;
            $start_date = $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Package"){
            $orgUser = $this->package->user;
            $start_date = $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Door to Door"){
            $orgUser = $this->d2dSchedule->user;
            $start_date = $this->d2dSchedule->depart_date;
        }

        $start_date = Carbon::parse($start_date);
        
        $cancellationRates = $orgUser->cancellationRates->sortBy("remaining_days");

        $percentage = $this->getCancellationRatePercent($start_date, $cancellationRates);
 
        $amount_paid = $this->getAmountPaid();
        return $amount_paid * ($percentage / 100);
    }

    public function getStartDate(){
        if($this->booking_type == "Vehicle"){
            return $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Package"){
            return $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Door to Door"){
            return $this->d2dSchedule->depart_date;
        }
    }

    public function getEndDate(){
        if($this->booking_type == "Vehicle"){
            return $this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days);
        }
        else if($this->booking_type == "Package"){
            return $this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days)->subHours(9);
        }
        else if($this->booking_type == "Door to Door"){
            return $this->d2dSchedule->depart_date->addDays(1);
        }
    }

    public function getRefundablePercentage(){

        $orgUser = null;
        $start_date = null;
        if($this->booking_type == "Vehicle"){
            $orgUser = $this->vehicle->user;
            $start_date = $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Package"){
            $orgUser = $this->package->user;
            $start_date = $this->bookingDetail->start_datetime;
        }
        else if($this->booking_type == "Door to Door"){
            $orgUser = $this->d2dSchedule->user;
            $start_date = $this->d2dSchedule->depart_date;
        }

        $start_date = Carbon::parse($start_date);
        
        $cancellationRates = $orgUser->cancellationRates->sortBy("remaining_days");

        return $this->getCancellationRatePercent($start_date, $cancellationRates);
    }

    public function extensionRequests(){
        return $this->hasMany(ExtensionRequest::class);
    }

    function getCancellationRatePercent($start_date, $cancellationRates) {
    
        // Sort the cancellation rates by remaining_days in ascending order
        $cancellationRates = collect($cancellationRates)->sortBy('remaining_days');
    
        // Get the current date and calculate the remaining days
        $currentDate = Carbon::now(); // Get today's date, adjust if needed
        $remainingDays = $currentDate->diffInDays(Carbon::parse($start_date), false); // Calculate remaining days
    
        // Iterate through the sorted cancellation rates to find the applicable one
        foreach ($cancellationRates as $rate) {
            // If remaining days is less than or equal to the cancellation rate's remaining_days
            if ($remainingDays <= $rate['remaining_days']) {
                return $rate['percent']; // Return the corresponding percentage
            }
        }
    
        // If no applicable rate is found, return a default percentage (e.g., 0 or a custom default)
        return 95;
    }

    public function getExtensionRequests(){
        return $this->hasMany(ExtensionRequest::class);
    }

    public function getLatestExtensionRequest() : ?ExtensionRequest {
        return ExtensionRequest::where("booking_id", $this->id)
        ->orderBy("created_at", "desc")
        ->first();
    }

    public function getOrganization(){
        if($this->booking_type == "Vehicle"){
            return $this->vehicle->user;
        }
        else if($this->booking_type == "Package"){
            return $this->package->user;
        }
        else if($this->booking_type == "Door to Door"){
            return $this->d2dSchedule->d2dVehicle->user;
        }
    }

    public function canReturn(){
        if($this->booking_type != "Vehicle"){
            return false;
        }
        
        if($this->status != "Booked"){
            return false;
        }

        if(now()->isAfter($this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days)->subHours(12))){
            return true;
        }

        return false;
    }

    public function isLateReturn() {
        if($this->booking_type != "Vehicle"){
            return false;
        }
        
        if($this->status != "Booked"){
            return false;
        }

        if(now()->isAfter($this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days))){
            return true;
        }

        return false;
    }

    public function computePenalty(){
        if($this->booking_type != "Vehicle"){
            return 0;
        }

        if(now()->isAfter($this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days))){
            $days = now()->diffInHours($this->bookingDetail->start_datetime->addDays($this->bookingDetail->number_of_days));
            $daysFloat = $days / 24;
            return $daysFloat * $this->vehicle->rate;
        }

        return 0;
    }

    public function getPenaltyPerHour(){
        if($this->booking_type != "Vehicle"){
            return 0;
        }
        return $this->vehicle->rate / 24;    
    }

    public function vehicleReturn () {
        return $this->hasOne(VehicleReturn::class);
    }

}
