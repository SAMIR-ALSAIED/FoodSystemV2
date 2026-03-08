<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\User\AddUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;

class UserController extends Controller
{

public function index(){


$users=User::with('roles')->get();



    return view('dashbord.users.index', compact('users'));



}

public function create(){


    $roles = Role::all();


    return view('dashbord.users.create',compact('roles'));




}

public function store(AddUserRequest $request){

 $data = $request->validated();
  $data['password'] = Hash::make($data['password']);

     $user = User::create($data);
    if(!empty($data['role'])) {
        $role = Role::find($data['role']);

            $user->assignRole($role->name);

    }
     return redirect()->route('users.index')->with('success', 'تم اضافة المستخدم بنجاح');


}



    public function edit(User $user)
    {


       $roles = Role::all();

        return view('dashbord.users.edit',compact('user','roles'));

    }



       public function update(UpdateUserRequest $request, User $user)
    {

         $data = $request->validated();


      if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    }
     else {
        unset($data['password']);
    }

        if (!empty($data['role'])) {
        $role = Role::find($data['role']);
        $user->syncRoles([$role->name]);
    }

    $user->update($data);

     return redirect()->route('users.index')->with('warning', 'تم تحديث المستخدم بنجاح');




    }
    public function destroy(User $user){


         $user->delete();


     return redirect()->route('users.index')->with('error', 'تم حذف المستخدم بنجاح');

    }









}
