<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    //
    public function index(Request $request) {
        $galleries = Gallery::query();
        if($request->has('search')) {
            $galleries->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        return view('landing.gallery')
            ->with([
                'galleries' => $galleries->paginate(10)
            ]);
    }

    public function galleries(Request $request)
    {
        $galleries = Gallery::query()->paginate(10);
        return view('main.admin.galleries.index')
            ->with([
                'galleries' => $galleries
            ]);
    }

    public function galleryStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required'
        ]);

        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/images/galleries'), $image_name);    

        Gallery::create([
            'title' => $request->title,
            'image' => $image_name,
            'description' => $request->description
        ]); 

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery created successfully');
    }

    public function galleryCreate(Request $request)
    {
        return view('main.admin.galleries.create');
    }

    public function galleryEdit(Request $request, $gallery_id)
    {
        $gallery = Gallery::find($gallery_id);
        return view('main.admin.galleries.edit')
            ->with([
                'gallery' => $gallery
            ]);
    }

    public function galleryDelete(Request $request, $gallery_id){
        $gallery = Gallery::find($gallery_id);
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted successfully');
    }

    public function galleryUpdate(Request $request, $gallery_id)
    {
        return DB::transaction(function () use ($request, $gallery_id) {
            $request->validate([
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'required'
            ]);
    
            $image = $request->file('image');
            if($image){
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/images/galleries'), $image_name);    
                Gallery::find($gallery_id)->update([
                    'image' => $image_name
                ]);
            }
    
            Gallery::find($gallery_id)->update([
                'title' => $request->title,
                'description' => $request->description
            ]); 
    
            return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully');
        });
    }
}
