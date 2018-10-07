<?php

namespace App\Http\Controllers\AdminPanel;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class managerController extends controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('manager.view')) {
            $managers = User::all();
            return view('manager.index', compact('managers'));
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('manager.create')){
            $roles = Role::all();
            return view('manager.create',compact('roles'));
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users_Admins',
            'password' =>'required|string|max:10|confirmed',
            'role' => 'required'
        ]);

        $request['password'] = bcrypt($request->password);
        $admin = User::create($request->all());

        $admin->roles()->sync($request->role);
//        Admin::find($id)->roles()->sync($request->role);


        return redirect('/manager')->withFlashMessage('Manager Stored');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('manager.update')) {
            $manager = User::find($id);
            $roles = Role::all();
            return view('manager.edit', compact('manager', 'roles'));
        }
        return redirect()->back();
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);
        $manager = User::find($id)->update($request->except('_token','_method','role'));
        User::find($id)->roles()->sync($request->role);
        return redirect('/manager')->withFlashMessage('Manager Edited');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('manager.delete')) {
            $admin = User::find($id)->delete();
            return redirect('/manager')->withFlashMessage('Manager Deleted');
        }
        return redirect()->back();
    }
}
