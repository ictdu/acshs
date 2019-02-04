<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Carousel;
use Image;
use Auth;
use App\Log;
use File;

class CarouselController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	$carousels = Carousel::orderBy('created_at', 'desc')->get();

    	return view('page-content.carousel.index')
            ->with('carousels', $carousels);
    }

    public function create() {
    	return view('page-content.carousel.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'carousel_image' => 'required|image'
    	]);

        $carousel = New Carousel;
        $carousel->title = $request->title;
        $carousel->content = $request->content;

        // save image
        if ($request->hasFile('carousel_image')) {
            $allowedfileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];
            $photo = $request->file('carousel_image');
            $extension = $photo->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $location = public_path('img/carousel/' . $filename);
                Image::make($photo)->resize(1200, 700)->save($location);

                // record activity
                $log = New Log;
                $log->user_id = Auth::user()->id;
                $log->type = 'carousel';
                $log->action = 'added a carousel';
                $log->crud = 'add';
                $log->save();

                $carousel->image = $filename;
            }
        }
        
        $carousel->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('carousel.index');

    }

    public function edit($id) {
        $carousel = Carousel::find($id);

        return view('page-content.carousel.edit')
            ->with('carousel', $carousel);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'carousel_image' => 'image'
        ]);

        $carousel = Carousel::find($id);
        $oldImage = $carousel->image;
        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'carousel';
        $log->action = 'modified a carousel';
        $log->crud = 'edit';
        $log->save();
        
        $carousel->title = $request->title;
        $carousel->content = $request->content;

        // save image
        if ($request->hasFile('carousel_image')) {
            $allowedfileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];
            $photo = $request->file('carousel_image');
            $extension = $photo->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $location = public_path('img/carousel/' . $filename);
                Image::make($photo)->resize(1200, 700)->save($location);
                File::delete(public_path('img/carousel/'. $oldImage)); // delete old image

                $carousel->image = $filename;
            }
        }
        
        $carousel->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('carousel.index');

    }

    public function destroy($id) {
        $carousel = Carousel::find($id);
        $oldImage = $carousel->image;
        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'carousel';
        $log->action = 'deleted a carousel';
        $log->crud = 'delete';
        $log->save();
        File::delete(public_path('img/carousel/'. $oldImage)); // delete old image
        $carousel->delete();

        // show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('carousel.index');
    }
}
