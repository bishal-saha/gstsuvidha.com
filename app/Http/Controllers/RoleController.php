<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller {

    public function __construct() {
        //$this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
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
            $roles = Role::where('name', 'like', '%'.$request->search.'%')
                ->orderby($sort, $order)
                ->paginate($limit);
        } else {
            $roles = Role::orderby($sort, $order)->paginate($limit);
        }

        $permissions = Permission::all();

        return view('backend.roles.index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'sort' => $request->sort,
            'order' => $request->order,
            'limit' => $request->limit,
            'search' => $request->search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::all();//Get all permissions

        return view('backend.roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
                'name'=>'required|unique:roles|max:10',
                'permissions' =>'required',
            ]
        );

        $role        = new Role();
        $role->name = $request->name;
        $role->save();

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $request->name)->first();
            $role->givePermissionTo($p);
        }

        $request->session()->flash('message', $role->name.' Role added successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json([ 'redirectTo' => redirect()->back()->getTargetUrl(),], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $role_permissions = $role->permissions;
        $rol_perm = array();
        foreach ($role_permissions as $role_permission) {
            array_push($rol_perm, $role_permission->id);
        }
        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
            'role_permissions' => $rol_perm,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('backend.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $role = Role::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $role->name = $request->name;
        $role->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }


        $request->session()->flash('message', $role->name.' Role updated successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json([
            'message' => 'Role updated successfully!',
            'redirectTo' => redirect()->back()->getTargetUrl(),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //Find the role with a given id and delete
        if($id) {
            $role = Role::findOrFail($id);
            $name = $role->name;
            $role->delete();
            $msg = 'Successfully deleted the role '.$name;
            $alert_type = 'success';
        } else {
            // Find all roles with selected ids and delete
            if($request->delete_ids!='') {
                Role::whereIn('id', $request->delete_ids)->delete();
                $msg = 'Successfully deleted the roles';
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

    /**
     * Display a listing of the resource without view.
     *
     *
     */
    public function list() {
        return Role::all();
    }
}