<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const TYPE_PER_HOUR = 'per_hour';
    const TYPE_PER_DAY = 'per_day';
    const TYPE_PER_PERSON = 'per_person';

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
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
}
