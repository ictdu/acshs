<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Album;
use Image;
use Auth;
use App\AlbumImage;
use File;
use App\Log;

class AlbumController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	$albums = Album::orderBy('created_at', 'desc')->get();

    	return view('page-content.album.index')
    		->with('albums', $albums);
    }

    public function create() {
    	return view('page-content.album.create');
    }

    public function store(Request $request) {
    	// dd(phpinfo());
    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'album_image' => 'required'
    	]);

    	// save album name
    	$album = New Album;
        $album->name = $request->name;
        $album->description = $request->description;
        $album->save();

    	if ($request->hasFile('album_image')) {

    		$allowedfileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];
            $photos = $request->file('album_image');

            foreach ($photos as $photo) {
                $photoName = $photo->getClientOriginalName();
                $photoName = str_replace(' ', '', $photoName);
                $extension = $photo->getClientOriginalExtension();
                $photoName = str_replace('.'.$extension, '', $photoName);
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $photoName.time() . '.' . $photo->getClientOriginalExtension();
                    $location = public_path('img/album/' . $filename);
                    // Image::make($photo)->resize(800, 400)->save($location);
                    Image::make($photo)->save($location);

                    

                    // save album images	
                    $image = New AlbumImage;
                    $image->album_id = $album->id;
                    $image->image = $filename;
                    $image->save();
                    
                }
            }

    	}

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'album';
        $log->action = 'added an album';
        $log->crud = 'add';
        $log->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('album.show', $album->id);
    }

    public function edit($id) {
    	$album = Album::find($id);
    	$photos = AlbumImage::where('album_id', $album->id)->orderBy('created_at', 'desc')->get();

    	return view('page-content.album.edit')
    		->with('album', $album)
    		->with('photos', $photos);
    }

    public function update(Request $request, $id) {

    	$this->validate($request, [
    		'name' => 'required|max:191'
    	]);

    	// remove the deleted image
        $photos = AlbumImage::where([['album_id', $id]])->get();
        foreach ($photos as $photo) {
            $check = in_array($photo->id, $_POST);
            if ($check) {
                continue;
            } else {
                $singlePhoto = AlbumImage::find($photo->id);
                $oldImage = $singlePhoto->image;
                File::delete(public_path('img/album/'. $oldImage)); // delete old image
                $singlePhoto->delete();
            }
        }

        // save edited album
        $album = Album::find($id);
        $album->name = $request->name;
        $album->description = $request->description;
        $album->save();

        // save image
        if ($request->hasFile('album_image')) {
            $allowedfileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];
            $photos = $request->file('album_image');

            // print_r($photos);
            foreach ($photos as $photo) {
                $photoName = $photo->getClientOriginalName();
                $photoName = str_replace(' ', '', $photoName);
                $extension = $photo->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $photoName. time() . '.' . $photo->getClientOriginalExtension();
                    $location = public_path('img/album/' . $filename);
                    Image::make($photo)->save($location);

                    // save album images	
                    $image = New AlbumImage;
                    $image->album_id = $album->id;
                    $image->image = $filename;
                    $image->save();
                    
                }
            }
        }

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'album';
        $log->action = 'modified an album';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('album.show', $album->id);
    }

    public function show($id) {
    	$album = Album::find($id);
    	$photos = AlbumImage::where('album_id', $album->id)->orderBy('created_at', 'desc')->get();

    	return view('page-content.album.show')
    		->with('album', $album)
    		->with('photos', $photos);
    }

    public function destroy($id) {
    	$album = Album::find($id);
    	$photos = AlbumImage::where([['album_id', $id]])->get();

    	// delete all images in album
    	foreach ($photos as $row) {
    		File::delete(public_path('img/album/'. $row->image)); // delete old image
    	}

    	$album->delete();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'album';
        $log->action = 'deleted an album';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();
    	return redirect()->route('album.index');
    }
}
