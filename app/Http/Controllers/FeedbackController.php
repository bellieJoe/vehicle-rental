<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
    public function index($type, $id) {
        if ($type == 'vehicle') {
            return $this->getVehicleFeedback($id);
        } else if ($type == 'package') {
            return $this->getPackageFeedback($id);
        }
    }
    
    private function getVehicleFeedback($id) {
        $vehicle = Vehicle::find($id);
        $bookings = Booking::where('vehicle_id', $id)
            ->whereHas('feedback')
            ->with('feedback') // Eager load feedback relationship
            ->paginate(10); // Paginate with 10 feedbacks per page
    
        return view('main.feedbacks.index')->with([
            'bookings' => $bookings,
            'type' => 'vehicle',
            'vehicle' => $vehicle
        ]);
    }
    
    private function getPackageFeedback($id) {
        $package = Package::find($id);
        $bookings = Booking::where('package_id', $id)
            ->whereHas('feedback')
            ->with('feedback') // Eager load feedback relationship
            ->paginate(10); // Paginate with 10 feedbacks per page
    
        return view('main.feedbacks.index')->with([
            'bookings' => $bookings,
            'type' => 'package',
            'package' => $package
        ]);
    }
    
}
