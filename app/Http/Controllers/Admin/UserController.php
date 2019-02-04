<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {

    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$users = User::where('user_type', '2')->orderBy('created_at', 'desc')->get();

    	return view('user.index')
    		->with('users', $users);
    }

    public function create() {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('user.create');
    }

    public function store(Request $request) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'email' => 'required|email|max:191|unique:users,email'
    	]);

    	$user = New User;
    	$user->user_type = 2;
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt('abcd123456');
    	$user->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('user.index');
    }

    public function edit($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$user = User::find($id);

    	return view('user.edit')
    		->with('user', $user);
    }

    public function update(Request $request, $id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);

    	$user = User::find($id);

        if ($user->email == $request->email) {
            $this->validate($request, [
                'firstname' => 'required|max:191'
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|max:191',
                'email' => 'required|string|email|max:255|unique:users,email'
            ]);
        }

    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('user.index');
    }

    public function destroy($id) {
    	// block other user
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$user = User::find($id);
    	$user->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('user.index');
    }

    public function getOnlineUsers() {
        $user = new User;
        // echo $user->allOnline()->count();
        foreach ($user->allOnline() as $row) {
            echo $row. "<br>";
        }
    }
}
