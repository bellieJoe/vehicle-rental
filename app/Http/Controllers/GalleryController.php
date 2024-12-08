<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryFeedback;
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

    // public function galleries(Request $request)
    // {
    //     $galleries = Gallery::query()->paginate(10);
    //     return view('main.admin.galleries.index')
    //         ->with([
    //             'galleries' => $galleries
    //         ]);
    // }

    public function galleries(Request $request) {
        $top_ten_galleries = DB::select("
            SELECT 
                galleries.id,
                galleries.title,
                galleries.image,
                galleries.description,
                galleries.created_at,
                galleries.updated_at, 
                AVG(gallery_feedbacks.rating) as avg_rating FROM `galleries`
            JOIN gallery_feedbacks ON gallery_feedbacks.gallery_id = galleries.id
            GROUP BY 
                galleries.id,
                galleries.title,
                galleries.image,
                galleries.description,
                galleries.created_at,
                galleries.updated_at
            ORDER BY avg_rating DESC
            LIMIT 10;
        ");
        $most_rated_galleries = DB::select("
            SELECT 
                galleries.id,
                galleries.title,
                galleries.image,
                galleries.description,
                galleries.created_at,
                galleries.updated_at, 
                count(1) as rating_count FROM `galleries`
            JOIN gallery_feedbacks ON gallery_feedbacks.gallery_id = galleries.id
            GROUP BY 
                galleries.id,
                galleries.title,
                galleries.image,
                galleries.description,
                galleries.created_at,
                galleries.updated_at
            ORDER BY rating_count DESC
            LIMIT 10;
        ");

        $galleries = Gallery::query()
            ->leftJoin('gallery_feedbacks', 'galleries.id', '=', 'gallery_feedbacks.gallery_id')
            ->select(
                'galleries.id',
                'galleries.title',
                'galleries.image',
                'galleries.description',
                'galleries.created_at',
                'galleries.updated_at', DB::raw('AVG(gallery_feedbacks.rating) as average_rating'))
            ->groupBy(
                'galleries.id',
                'galleries.title',
                'galleries.image',
                'galleries.description',
                'galleries.created_at',
                'galleries.updated_at'
            )
            ->orderBy('average_rating', 'desc');

            // return json_encode($galleries->get());
    
        return view('main.admin.galleries.index')->with([
            'galleries' => $galleries->paginate(10),
            'top_ten_galleries' => $top_ten_galleries,
            'most_rated_galleries' => $most_rated_galleries
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

    public function addFeedback(Request $request, $gallery_id) {
        $request->validate([
            'rating' => 'required',
            'review' => 'required'
        ]);

        $feedback = GalleryFeedback::where(['user_id' => auth()->user()->id, 'gallery_id' => $gallery_id])->first();

        if($feedback) {
            $feedback->update([
                'rating' => $request->rating,
                'review' => $request->review
            ]);
            return redirect()->route('galleries')->with('success', 'Feedback updated successfully');
        }
        GalleryFeedback::create([
            'user_id' => auth()->user()->id,
            'gallery_id' => $gallery_id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->route('galleries')->with('success', 'Feedback added successfully');
    }
}
