<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function vehicleCategory (){
        return $this->belongsTo(VehicleCategory::class);
    }

    public function user (){
        return $this->belongsTo(User::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function computeFeedbackAverage()
    {
        // Get the feedbacks related to the current vehicle or package
        // First, retrieve the bookings related to this specific vehicle/package
        $feedbacks = $this->bookings() // Assuming the relationship is defined as 'bookings' in the model
                        ->whereHas('feedback') // Ensure the booking has feedback
                        ->with('feedback') // Eager load the feedback for each booking
                        ->get()
                        ->pluck('feedback') // Get all feedbacks from the bookings
                        ->flatten(); // Flatten the collection to get a single collection of feedbacks

        // Pluck the ratings from feedbacks
        $ratings = $feedbacks->pluck('rating');

        // Calculate the average rating
        $average = $ratings->isNotEmpty() ? $ratings->average() : 0;

        return round($average, 2); // Return the rounded average rating
    }

    public function countFeedbacks()
    {
        // Get the feedbacks related to the current vehicle or package
        // First, retrieve the bookings related to this specific vehicle/package
        $feedbackCount = $this->bookings() // Assuming the relationship is defined as 'bookings' in the model
                            ->whereHas('feedback') // Ensure the booking has feedback
                            ->count(); // Count the number of bookings with feedback

        return $feedbackCount; // Return the number of feedbacks
    }

    public static function isVehicleAvailable($vehicle_id, $start_datetime, $number_of_days, $status) {
        $end_datetime = Carbon::parse($start_datetime)->addDays($number_of_days);
    
        $overlappingBookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where('bookings.vehicle_id', $vehicle_id)
            ->where('bookings.status', $status)
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where(function ($q) use ($start_datetime) {
                    $q->where('booking_details.start_datetime', '<=', $start_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) > ?', [$start_datetime]);
                })
                ->orWhere(function ($q) use ($end_datetime) {
                    $q->where('booking_details.start_datetime', '<', $end_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) >= ?', [$end_datetime]);
                });
            })
            ->exists();
    
        return !$overlappingBookings; // Returns true if no overlap, meaning the vehicle is available
    }
}

