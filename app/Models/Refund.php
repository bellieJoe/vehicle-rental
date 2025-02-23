<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'refunded_at'];

    const STATUS_PENDING = 'pending';
    const STATUS_REFUNDED = 'refunded';

    public function booking(){
        return $this->belongsTo(Booking::class);
    }
}
