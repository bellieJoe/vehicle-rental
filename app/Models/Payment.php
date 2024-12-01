<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['payment_exp', 'date_paid'];

    const OPTION_INSTALLMENT = 'Installment';
    const OPTION_FULL_PAYMENT = 'Full';

    const STATUS_PENDING = 'Pending';
    const STATUS_GCASH_APPROVAL = 'For Approval';
    const STATUS_GCASH_INVALID = 'Payment Invalid';
    const STATUS_PAID = 'Paid';
    const STATUS_FAILED = 'Failed';

    const METHOD_CASH = 'Cash';
    const METHOD_GCASH = 'GCash';
    const METHOD_DEBIT = 'Debit';

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // The check if expired method
    public function checkIfExpiredAndSetStatus()
    {
        if ($this->payment_exp && $this->payment_exp < now()) {
            $this->payment_status = self::STATUS_FAILED;
            $this->save(); // Ensure the status is saved when expired
        }
    }

    // Running the check on model retrieval
    // protected static function booted()
    // {
    //     static::retrieved(function ($payment) {
    //         $payment->checkIfExpiredAndSetStatus();
    //     });
    // }
}
