<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Announcement;
use App\Models\Administration;
use App\Album;
use App\AlbumImage;

class PageController extends Controller
{
    public function facilityPage() {
    	$facilities = Facility::orderBy('created_at', 'desc')->get();

    	return view('facilities')
    		->with('facilities', $facilities);
    }

    public function announcementPage() {
    	$announcements = Announcement::orderBy('created_at', 'desc')->get();

    	return view('announcements')
    		->with('announcements', $announcements);
    }

    public function administrationPage() {
    	$administrations = Administration::orderBy('created_at', 'desc')->get();

    	return view('administrations')
    		->with('administrations', $administrations);
    }

    public function albumPage() {
        // album
        $albums = Album::orderBy('created_at', 'desc')->get();
        $albumsArr = [];
        $x = 0;
        $highest = 0;
        foreach ($albums as $row) {
            $albumImages = AlbumImage::where('album_id', $row->id)->get();
            foreach ($albumImages as $albumImage) {
                if ($highest < $albumImage->id) {
                    $highest = $albumImage->id;
                }
            }
            $thumbnail = AlbumImage::find($highest);

            $albumsArr[$x++] = [
                'id' => $row->id,
                'name' => $row->name,
                'description' => $row->description,
                'thumbnail' => $thumbnail->image,
                'created_at' => $row->created_at
            ];

            // reset highest
            $highest = 0;
        }

        $albumsArr = json_decode(json_encode($albumsArr));

        return view('albums')
            ->with('albums', $albumsArr);
    }

    public function albumImagesPage($id) {
        $album = Album::find($id);
        $albumImages = AlbumImage::where('album_id', $id)->orderBy('created_at', 'desc')->get();

        return view('album-images')
            ->with('album', $album)
            ->with('albumImages', $albumImages);
    }
}
