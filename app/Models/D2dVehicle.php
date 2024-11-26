<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class D2dVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function d2dSchedules(){
        return $this->hasMany(D2dSchedule::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function renderStartingPrice()
    {
        // Check if there are any associated schedules
        if (!$this->d2dSchedules()->exists()) {
            return "N/A";
        }

        // Map rates from associated schedules, ensuring soft-deleted relations are ignored
        $prices = $this->d2dSchedules()
            ->with('route') // Ensure route relationship is eager-loaded
            ->get()
            ->filter(fn($schedule) => isset($schedule->route->rate)) // Filter out invalid rates
            ->pluck('route.rate'); // Extract the rate values

        // If there are no valid rates, return N/A
        if ($prices->isEmpty()) {
            return "N/A";
        }

        // Return the minimum rate formatted as currency
        return "PHP " . number_format($prices->min(), 2);
    }

    public function computeFeedbackAverage()
    {
        // Retrieve all feedback ratings for the current vehicle/package
        $ratings = $this->d2dSchedules()
            ->with(['bookings.feedback' => function ($query) {
                $query->select('id', 'rating', 'booking_id'); // Ensure the `rating` field and relevant IDs are retrieved
            }])
            ->get()
            ->flatMap(function ($schedule) {
                return $schedule->bookings->flatMap(function ($booking) {
                    return $booking->feedback ? [$booking->feedback->rating] : [];
                });
            });

        // Calculate the average rating
        $average = $ratings->isNotEmpty() ? $ratings->avg() : 0;

        return round($average, 2); // Return rounded average, defaulting to 0 if no ratings exist
    }


    public function countFeedbacks()
    {
        // Count the total feedbacks for this vehicle/package via bookings
        $feedbackCount = $this->d2dSchedules()
            ->whereHas('bookings', function ($query) {
                $query->whereHas('feedback'); // Ensure bookings have feedback
            })
            ->with(['bookings.feedback'])
            ->get()
            ->sum(function ($schedule) {
                return $schedule->bookings->filter(function ($booking) {
                    return $booking->feedback !== null; // Only count bookings with feedback
                })->count();
            });

        return $feedbackCount; // Return the total feedback count
    }



}
