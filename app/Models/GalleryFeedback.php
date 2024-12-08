<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryFeedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gallery_feedbacks';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
