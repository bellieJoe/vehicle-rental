<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function organisation(){
        return $this->belongsTo(Organisation::class);
    }

    public function ratings(){
        return $this->hasMany(GalleryFeedback::class);
    }

    public function getAverageRating(){
        return $this->ratings()->avg('rating');
    }
}
