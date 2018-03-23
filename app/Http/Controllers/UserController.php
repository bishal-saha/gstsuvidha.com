<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'isAdmin']);
        //isAdmin middleware lets only users with a
        // //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        //Get all users and pass it to the view
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
            $users = User::where('name', 'like', '%'.$request->search.'%')
                            ->orWhere('email', 'like', '%'.$request->search.'%')
                            ->orderby($sort, $order)
                            ->paginate($limit);
        } else {
            $users = User::orderby($sort, $order)->paginate($limit);
        }

        return view('backend.users.index', [
            'users' => $users,
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
    public function create()
    {
        $roles = Role::get();
        return view('backend.users.create', ['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $roles = $request['roles']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }

        $request->session()->flash('message', 'The user '.$request->name.' added successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json([ 'redirectTo' => redirect()->back()->getTargetUrl(),], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $user->getRoleNames();

        return response()->json([
            'user' => $user,
            'roles' => $roles
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'string|min:6',
        ]);

        $user        = User::findOrFail($id);
        $user->name  = $request->name;
        $user->email = $request->email;

        if($request->password !='' && $request->password_confirmation != '') {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $roles = $request->roles; //Retreive all roles

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }

        $request->session()->flash('message', 'The user '. $user->name.' updated successfully.');
        $request->session()->flash('alert-type', 'success');

        return response()->json([
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
        //Find a user with a given id and delete
        if($id) {
            $user = User::findOrFail($id);
            $user_name = $user->name;
            $user->delete();
            $msg = 'Successfully deleted the user '.$user_name;
            $alert_type = 'success';
        } else {
            //Find a user with a given id and delete
            if($request->ids!='') {
                User::whereIn('id', explode(',', $request->delete_ids))->delete();
                $msg = 'Successfully deleted the users';
                $alert_type = 'success';
            } else {
                $msg = 'You have not selected any user to delete. Please check the checkbox to delete.';
                $alert_type = 'warning';
            }
        }

        $request->session()->flash('message', $msg);
        $request->session()->flash('alert-type', $alert_type);

        return response()->json(['redirectTo' => redirect()->back()->getTargetUrl()], 200);
    }
}
