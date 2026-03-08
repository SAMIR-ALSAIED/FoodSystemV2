<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\AddRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

public function index(){


$roles=Role::all();

return view('dashbord.roles.index',compact('roles'));

}

public function create(){

$permissions=Permission::all();

return view('dashbord.roles.create',compact('permissions'));

}

public function store(AddRoleRequest $request){

   $data = $request->validated();

$role = Role::firstOrCreate([
    'name' => $data['name'],
    'guard_name' => 'web',
]);

 $permissions = Permission::find($request->permissions);
    $role->syncPermissions( $permissions);

    return redirect()->route('roles.index')->with('success', 'تم إنشاء الدور بنجاح!');


}


public function edit( Role $role){

$permissions = Permission::all();
return view('dashbord.roles.edit',compact('role','permissions'));

}

public function update(UpdateRoleRequest $request, Role $role){

 $data = $request->validated();

      $role->update([
            'name' => $data['name'],
        ]);
     $permissions = Permission::find($data['permissions']);
    $role->syncPermissions($permissions);

}



    public function destroy(Role $role){


         $role->delete();


     return redirect()->route('roles.index')->with('error', 'تم حذف الصلاحية بنجاح');

}

}
