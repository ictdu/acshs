<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Logo;
use Image;
use Auth;
use App\Log;
use Storage;
use File;

class LogoController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	$logos = Logo::orderBy('created_at', 'desc')->get();

    	return view('page-content.logo.index')
    		->with('logos', $logos);
    }

    public function create() {
    	return view('page-content.logo.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'logo_image' => 'required|image'
    	]);

    	if ($request->hasFile('logo_image')) {
    		$logo = New Logo;

    		$allowedfileExtension = ['png', 'PNG'];
            $photo = $request->file('logo_image');
            $extension = $photo->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $location = public_path('img/logo/' . $filename);
                Image::make($photo)->resize(600, 600)->save($location);

                $logo->image = $filename;
                $logo->save();

                // record activity
                $log = New Log;
                $log->user_id = Auth::user()->id;
                $log->type = 'logo';
                $log->action = 'added a logo';
                $log->crud = 'add';
                $log->save();

                // show a success message
		        \Alert::success('The item has been added successfully.')->flash();

		        return redirect()->route('logo.index');
            } else {
            	// show a error message
		        \Alert::error('Please upload a png file!')->flash();

		        return redirect()->back();
            }
    	}
    }

    public function edit($id) {
        $logo = Logo::find($id);

        return view('page-content.logo.edit')
            ->with('logo', $logo);
    }

    public function update(Request $request, $id) {
    	$this->validate($request, [
    		'logo_image' => 'required|image'
    	]);

    	if ($request->hasFile('logo_image')) {
    		$logo = Logo::find($id);

    		$allowedfileExtension = ['png', 'PNG'];
            $photo = $request->file('logo_image');
            $extension = $photo->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $location = public_path('img/logo/' . $filename);
                Image::make($photo)->resize(600, 600)->save($location);
                $oldImage = $logo->image; //old imagename

                // record activity
                $log = New Log;
                $log->user_id = Auth::user()->id;
                $log->type = 'logo';
                $log->action = 'modified a logo';
                $log->crud = 'edit';
                $log->save();

                $logo->image = $filename;
                File::delete(public_path('img/logo/'. $oldImage)); // delete old image
                $logo->save();

                // show a success message
		        \Alert::success('The item has been modified successfully.!')->flash();

		        return redirect()->route('logo.index');
            } else {
            	// show a error message
		        \Alert::error('Please upload a png file!')->flash();

		        return redirect()->back();
            }
    	}
    }

    public function destroy($id) {
        $logo = Logo::find($id);
        $oldImage = $logo->image;

        // record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'logo';
        $log->action = 'deleted a logo';
        $log->crud = 'delete';
        $log->save();

        $logo->delete();
        File::delete(public_path('img/logo/'. $oldImage)); // delete old image

        // show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('logo.index');
    }
}
