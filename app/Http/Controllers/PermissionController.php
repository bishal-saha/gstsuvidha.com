<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;
class PermissionController extends Controller
{
    public function __construct() {
        //$this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return
     */
    public function index(Request $request) {
        if($request->sort != '') {
            $sort = $request->sort;
        } else {
            $sort = 'id';
        }
        if($request->order != '') {
            $order = $request->order;
        } else {
            $order = 'desc';
        }
        if($request->limit != '') {
            $limit = $request->limit;
        } else {
            $limit = 10;
        }
        if($request->search != '') {
            $permissions = Permission::where('name', 'like', '%'.$request->search.'%')
                ->orderby($sort, $order)
                ->paginate($limit);
        } else {
            $permissions = Permission::orderby($sort, $order)->paginate($limit);
        }

        return view('backend.permissions.index', [
                    'permissions' => $permissions,
                    'sort'        => $request->sort,
                    'order'       => $request->order,
                    'limit'       => $request->limit,
                    'search'      => $request->search
                ]);
    }

    /**
     * Display a listing of the resource without view.
     *
     *
     */
    public function list() {
        return Permission::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create() {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:60|unique:permissions,name',
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        $request->session()->flash('message', 'The permission '.$permission->name.' added successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json(['redirectTo' => redirect()->back()->getTargetUrl(), ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $permission = Permission::findOrFail($id);
        return response()->json([ 'permission' => $permission], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name'=>'required|max:60|unique:permissions,name,'.$id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();

        $request->session()->flash('message', $permission->name.' updated successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json(['redirectTo' => redirect()->back()->getTargetUrl(), ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($id) {
            $permission = Permission::findOrFail($id);
            $name = $permission->name;
            $permission->delete();

            $msg = 'Successfully deleted: '.$name;
            $alert_type = 'success';
        } else {
            if($request->delete_ids!='') {
                Permission::whereIn('id', $request->delete_ids)->delete();
                $msg = 'Successfully deleted the selected records';
                $alert_type = 'success';
            } else {
                $msg = 'You have not selected any row to delete. Please check the checkbox to delete.';
                $alert_type = 'warning';
            }
        }

        $request->session()->flash('message', $msg);
        $request->session()->flash('alert-type', $alert_type);

        return response()->json(['redirectTo' => redirect()->back()->getTargetUrl()], 200);
    }
}