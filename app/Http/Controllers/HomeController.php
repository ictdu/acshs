<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Announcement;
use App\Models\Administration;
use App\Album;
use App\AlbumImage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function landingpage()
    {
        // album
        $albums = Album::orderBy('created_at', 'desc')->paginate(3);
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
        
        $allAlbum = Album::all();
        $albumSeeMore = false;
        if ($allAlbum->count() > 3) {
            $albumSeeMore = true;
        }

        // fac
        $facilities = Facility::orderBy('created_at', 'desc')->paginate(6);
        $facSeeMore = false;
        $allFac = Facility::all();
        if ($allFac->count() > 6) {
            $facSeeMore = true;
        }
        
        // admin
        $allAdmin = Administration::all();
        $administrations = Administration::orderBy('created_at', 'desc')->paginate(6);
        $adminSeeMore = false;
        if ($allAdmin->count() > 6) {
            $adminSeeMore = true;
        }

        // ann
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(4);
        $annSeeMore = false;
        $allAnn = Announcement::all();
        if ($allAnn->count() > 4) {
            $annSeeMore = true;
        }


        $albumsArr = json_decode(json_encode($albumsArr));

        // print_r($albumsArr);
        return view('welcome')
            ->with('facilities', $facilities)
            ->with('facSeeMore', $facSeeMore)
            ->with('administrations',$administrations)
            ->with('adminSeeMore', $adminSeeMore)
            ->with('announcements', $announcements)
            ->with('annSeeMore', $annSeeMore)
            ->with('albums', $albumsArr)
            ->with('albumSeeMore', $albumSeeMore);
    }
}
