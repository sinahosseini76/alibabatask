<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Modules\Core\Http\Controllers\CoreController;

class RoleController extends CoreController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update','changeStatus']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->forget(['swal-success-message','swal-error-message']);
        $roles = Role::orderBy('id','DESC')->paginate(30);
        $permissions = Permission::get();



        return view('pages.role-index',compact('roles', 'permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 30);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('pages.role-create',compact('permissions'));
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
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);


        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));



            session()->flash('success-message', 'Role created successfully');

            return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('pages.role-show',compact('role','rolePermissions','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('pages.role-edit',compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id,
            'permissions' => 'required|array',
        ]);

        $before = $role->toArray();
        $beforeRolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->get();
         $before['permissions'] = $beforeRolePermissions;


        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));




        session()->flash('success-message', 'Role updated successfully');
        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return false
     */
    public function destroy($id)
    {
        // can not delete admin role
        if ($id == 1) {
            session()->flash('swal-error-message', 'Can not delete admin role');
            return response(['message' => 'Role Can Not deleted'],500);
        }

        $role  = Role::where('id',$id)->first();


        $role->delete();
        session()->flash('swal-success-message', 'Role deleted successfully');
        return response(['message' => 'Role deleted successfully']);
    }

    public function changeStatus(Request $request)
    {
        $role = Role::find($request->role_id);
        $role->status = $role->status == 'active' ? 'inactive' : 'active';
        $role->save();




        return redirect()->back();
    }
}
