<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //
    public function index() {
        $galleries = Gallery::query()->paginate(10);
        return view('landing.gallery')
            ->with([
                'galleries' => $galleries
            ]);
    }
}
