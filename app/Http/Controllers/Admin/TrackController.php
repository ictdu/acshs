<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Track;
use App\Log;
use Auth;
use App\Student;
use App\Section;

class TrackController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$tracks = Track::orderBy('updated_at', 'desc')->get();
        $cantDelete = [];
        $students = Student::all();
        $sections = Section::all();
        foreach ($students as $row) {
            if (!in_array($row->track_id, $cantDelete)) {
                array_push($cantDelete, $row->track_id);
            }
        }

        foreach ($sections as $row) {
            if (!in_array($row->track_id, $cantDelete)) {
                array_push($cantDelete, $row->track_id);
            }
        }

    	return view('admin-grade-management.track.index')
    		->with('tracks', $tracks)
            ->with('cantDelete', $cantDelete);
    }

    public function create() {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin-grade-management.track.create');
    }

    public function store(Request $request) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191'
    	]);

    	$track = New Track;
    	$track->name = $request->name;
    	$track->save();

    	// record activity
        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'track';
        $log->action = 'added a track';
        $log->crud = 'add';
        $log->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('track.index');
    }

    public function edit($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $track = Track::find($id);

        return view('admin-grade-management.track.edit')
            ->with('track', $track);
    }

    public function update(Request $request, $id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'name' => 'required|max:191'
        ]);

        $track = Track::find($id);
        $track->name = $request->name;
        $track->save();

        $log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'track';
        $log->action = 'modified a track';
        $log->crud = 'edit';
        $log->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('track.index');
    }

    public function destroy($id) {
        // block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$track = Track::find($id);
    	$track->delete();

    	$log = New Log;
        $log->user_id = Auth::user()->id;
        $log->type = 'track';
        $log->action = 'deleted a track';
        $log->crud = 'delete';
        $log->save();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

    	return redirect()->back();

    }

    public function downloadAll() {
        $tracks = Track::all();

        // ---------------------------------------------
        
        $dataToDownload = [];
        $x = 0;
        $csvName = 'TrackList';

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
         
        // send the column headers
        fputcsv($file, array('ID', 'Track'));
         
        foreach($tracks as $row) {
            $dataToDownload[$x++] = [
                'id' => $row->id,
                'name' => $row->name
            ];
        }
         
        //print_r($dataToDownload);
        // output each row of the data
        foreach ($dataToDownload as $row)
        {
        fputcsv($file, $row);
        }
         
        exit();
    }
}
