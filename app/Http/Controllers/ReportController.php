<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    // public function collections() {
    //     $filter = request()->query('filter'); // 'daily', 'weekly', or 'monthly'
    //     $userId = auth()->user()->id;

    //     if(!$filter) {
    //         $filter = 'monthly';
    //     }
    
    //     $payments = Payment::query()
    //         ->where('payment_status', Payment::STATUS_PAID)
    //         ->where(function ($query) use ($userId) {
    //             $query->whereHas('booking.vehicle.user', function ($query) use ($userId) {
    //                 $query->where('user_id', $userId);
    //             })
    //             ->orWhereHas('booking.package.user', function ($query) use ($userId) {
    //                 $query->where('user_id', $userId);
    //             })
    //             ->orWhereHas('booking.d2dSchedule.d2dVehicle.user', function ($query) use ($userId) {
    //                 $query->where('user_id', $userId);
    //             });
    //         });
    
    //     // Apply filter for daily, weekly, and monthly
    //     if ($filter === 'daily') {
    //         $payments->whereDate('date_paid', today());
    //     } elseif ($filter === 'weekly') {
    //         $payments->whereBetween('date_paid', [now()->startOfWeek(), now()->endOfWeek()]);
    //     } elseif ($filter === 'monthly') {
    //         $payments->whereMonth('date_paid', now()->month)
    //                  ->whereYear('date_paid', now()->year);
    //     }

    //     $totalCollections = $payments->sum('amount');
    
    //     return view('reports.collection-report')->with([
    //         'payments' => $payments,
    //         'filter' => $filter,
    //         'totalCollections' => $totalCollections
    //     ]);
    // }

    public function collections() {
        $filter = request()->query('filter', 'monthly'); // Default to 'monthly' if not provided
        $date = request()->query('date'); // Used for daily filter
        $week = request()->query('week'); // Used for weekly filter
        $month = request()->query('month'); // Used for monthly filter
        $userId = auth()->user()->id;
    
        // Base query to fetch payments
        $payments = Payment::query()
            ->where('payment_status', Payment::STATUS_PAID)
            ->where(function ($query) use ($userId) {
                $query->whereHas('booking.vehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('booking.package.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('booking.d2dSchedule.d2dVehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            });
    
        // Apply filters based on the selected type
        if ($filter === 'daily' && $date) {
            $payments->whereDate('date_paid', $date);
        } elseif ($filter === 'weekly' && $week) {
            $startOfWeek = \Carbon\Carbon::parse($week)->startOfWeek();
            $endOfWeek = \Carbon\Carbon::parse($week)->endOfWeek();
            $payments->whereBetween('date_paid', [$startOfWeek, $endOfWeek]);
        } elseif ($filter === 'monthly' && $month) {
            [$year, $month] = explode('-', $month); // Extract year and month
            $payments->whereMonth('date_paid', $month)
                     ->whereYear('date_paid', $year);
        }
    
        // Calculate total collections
        $totalCollections = $payments->sum('amount');
    
        // Return the view with the filtered data
        return view('reports.collection-report')->with([
            'payments' => $payments->get(), // Execute the query
            'filter' => $filter,
            'totalCollections' => $totalCollections,
        ]);
    }
    
    
    public function refunds() {
        $filter = request()->query('filter', 'monthly'); // 'daily', 'weekly', or 'monthly'
        $userId = auth()->user()->id;
        $date = request()->query('date', now()->toDateString()); // Default to today's date
        $week = request()->query('week', now()->startOfWeek()->toDateString()); // Default to current week
        $month = request()->query('month', now()->format('Y-m')); // Default to current month (e.g., "2024-12")

        if(!$filter) {
            $filter = 'monthly';
        }
    
        $refunds = Refund::query()
            ->where('status', Refund::STATUS_REFUNDED)
            ->where(function ($query) use ($userId) {
                $query->whereHas('booking.vehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('booking.package.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('booking.d2dSchedule.d2dVehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            });
    
        // Apply filter for daily, weekly, and monthly
        if ($filter === 'daily') {
            $refunds->whereDate('refunded_at', $date);
        } elseif ($filter === 'weekly') {
            $startOfWeek = \Carbon\Carbon::parse($week)->startOfWeek();
            $endOfWeek = \Carbon\Carbon::parse($week)->endOfWeek();
            $refunds->whereBetween('refunded_at', [$startOfWeek, $endOfWeek]);
        } elseif ($filter === 'monthly') {
            [$year, $month] = explode('-', $month); // Extract year and month
            $refunds->whereMonth('refunded_at', $month)
                     ->whereYear('refunded_at', $year);
        }

        $totalCollections = $refunds->sum('amount');
    
        return view('reports.refund-report')->with([
            'refunds' => $refunds->get(),
            'filter' => $filter,
            'totalCollections' => $totalCollections
        ]);
    }

    public function cancellations() {
        $filter = request()->query('filter', 'monthly'); // 'daily', 'weekly', or 'monthly'
        $userId = auth()->user()->id;
        $date = request()->query('date', now()->toDateString()); // Default to today's date
        $week = request()->query('week', now()->startOfWeek()->toDateString()); // Default to current week
        $month = request()->query('month', now()->format('Y-m')); // Default to current month (e.g., "2024-12")
        $userId = auth()->user()->id;

        if(!$filter) {
            $filter = 'monthly';
        }
    
        $bookings = Booking::query()
            ->where('status', Booking::STATUS_CANCELLED)
            ->where(function ($query) use ($userId) {
                $query->whereHas('vehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('package.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orWhereHas('d2dSchedule.d2dVehicle.user', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            });
    
        // Apply filter for daily, weekly, and monthly
        if ($filter === 'daily') {
            $bookings->whereDate('updated_at', $date);
        } elseif ($filter === 'weekly') {
            $startOfWeek = \Carbon\Carbon::parse($week)->startOfWeek();
            $endOfWeek = \Carbon\Carbon::parse($week)->endOfWeek();
            $bookings->whereBetween('updated_at', [$startOfWeek, $endOfWeek]);
        } elseif ($filter === 'monthly') {
            [$year, $month] = explode('-', $month); // Extract year and month
            $bookings->whereMonth('updated_at', $month)
                     ->whereYear('updated_at', $year);
        }
    
        return view('reports.cancellation-report')->with([
            'bookings' => $bookings->get(),
            'filter' => $filter,
        ]);
    }
    
}
