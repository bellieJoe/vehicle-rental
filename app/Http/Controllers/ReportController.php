<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function collections() {
        $filter = request()->query('filter'); // 'daily', 'weekly', or 'monthly'
        $userId = auth()->user()->id;

        if(!$filter) {
            $filter = 'monthly';
        }
    
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
    
        // Apply filter for daily, weekly, and monthly
        if ($filter === 'daily') {
            $payments->whereDate('date_paid', today());
        } elseif ($filter === 'weekly') {
            $payments->whereBetween('date_paid', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'monthly') {
            $payments->whereMonth('date_paid', now()->month)
                     ->whereYear('date_paid', now()->year);
        }

        $totalCollections = $payments->sum('amount');
    
        return view('reports.collection-report')->with([
            'payments' => $payments->paginate(10),
            'filter' => $filter,
            'totalCollections' => $totalCollections
        ]);
    }
    
    public function refunds() {
        $filter = request()->query('filter'); // 'daily', 'weekly', or 'monthly'
        $userId = auth()->user()->id;

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
            $refunds->whereDate('refunded_at', today());
        } elseif ($filter === 'weekly') {
            $refunds->whereBetween('refunded_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'monthly') {
            $refunds->whereMonth('refunded_at', now()->month)
                     ->whereYear('refunded_at', now()->year);
        }

        $totalCollections = $refunds->sum('amount');
    
        return view('reports.refund-report')->with([
            'refunds' => $refunds->paginate(10),
            'filter' => $filter,
            'totalCollections' => $totalCollections
        ]);
    }
    
}
