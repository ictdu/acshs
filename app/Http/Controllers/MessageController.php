<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Session;

class MessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
                'name'           => 'required|max:255',
                'email'            => 'required|max:255',
                'contact'     => 'required',
                'message'            => 'required'
            ));

        $messages = new Message;

        $messages->name = $request->name;
        $messages->email = $request->email;
        $messages->contact = $request->contact;
        $messages->message = $request->message;
        // $messages->seen = 0;
        $messages->save();

        Session::flash('success', 'Message Successfully Sent');

        return redirect()->back();
    }

    
}
