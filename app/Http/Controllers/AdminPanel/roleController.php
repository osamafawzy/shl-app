<?php

namespace App\Http\Controllers\AdminPanel;


use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class roleController extends Controller
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
        $roles = Role::all();
        return view('role.index',compact('roles'));
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
        if (Auth::user()->can('manager.create')) {
            $permissions = Permission::all();
            return view('role.create', compact('permissions'));
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
            'title' => 'required|max:20|unique:roles'
        ]);
        $role = new Role();
        $role->title = $request->title;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect('/role')->withFlashMessage('Role Added');
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
            $role = Role::find($id);
            $permissions = Permission::all();
            return view('role.edit', compact('role', 'permissions'));
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
            'title' => 'required|max:20'
        ]);
        $role = Role::find($id);
        $role->title = $request->title;
        $role->save();
        $role->permissions()->sync($request->permission);
        return redirect('/role')->withFlashMessage('Role Edited');

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
            $role = Role::find($id)->delete();
            return redirect('/role')->withFlashMessage('Role Deleted');
        }
        return redirect()->back();
    }
}
