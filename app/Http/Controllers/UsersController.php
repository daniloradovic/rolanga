<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tournament;
use Validator;
use Auth;
use Image;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the users 
        $users = User::all();

        // load the view and pass the users
        return view('users.index', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(Auth::check() && Auth::user()->id == $user->id){    
            return view('users.edit',compact('user'));
        }

        else{
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('users/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } 
        else {
            // store
            $user = User::find($id);
            $user->name       = $request->get('name');
            $user->email      = $request->get('email');
            $user->save();

            // redirect
            session()->flash('message', 'Successfully updated player!');
            return redirect()->route('users.show',['user'=> $user->id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function update_avatar(Request $request)
    {

        // Handle upload of users avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename));

            $user = Auth::user();

            $user->avatar = $filename;
            
            $user->save();
        }

        return view('users.show', compact('user'));

    }
}
