<?php

namespace App\Http\Controllers\AdminPanel;


use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class permissionController extends Controller
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
            $permissions = Permission::all();
            return view('permission.index', compact('permissions'));
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
            $roles = Role::all();
            return view('permission.create', compact('roles'));
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
            'title' => 'required|max:30|unique:permissions',
            'for' => 'required'
        ]);
        $permission = new Permission();
        $permission->title = $request->title;
        $permission->for = $request->for;
        $permission->save();
        return redirect('/permission')->withFlashMessage('Permission Added');
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
            $permission = Permission::find($id);
            return view('permission.edit', compact('permission'));
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
            'title' => 'required|max:30'
        ]);
        $permission = Permission::find($id);
        $permission->title = $request->title;
        $permission->for = $request->for;
        $permission->save();
        return redirect('/permission')->withFlashMessage('Permission Edited');
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
            $permission = Permission::find($id)->delete();
            return redirect('/permission')->withFlashMessage('Permission Deleted');
        }
        return redirect()->back();
    }
}
