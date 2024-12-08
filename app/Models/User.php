<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'contact_number',
        'profile_picture',
        'is_banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organisation()
    {
        return $this->hasOne(Organisation::class, 'user_id', 'id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id', 'id');
    }

    public function vehicleCategories()
    {
        return $this->hasMany(VehicleCategory::class, 'user_id', 'id');
    }

    public function additionalRates(){
        return $this->hasMany(AdditionalRate::class);
    }

    public function cancellationRates(){
        return $this->hasMany(CancellationRate::class);
    }

    public function getFrequentlyRentedvehicles(){
        $vehicles = Vehicle::where('user_id', $this->id)
        ->withCount('bookings')
        // ->where('bookings_count', '>', 0)
        // ->orderBy('bookings_count', 'desc')
        ->limit(10)
        ->get()
        ->sortByDesc('bookings_count', SORT_NUMERIC);
        
        return $vehicles;
    }
}

