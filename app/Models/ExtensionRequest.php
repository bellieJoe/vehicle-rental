<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtensionRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
