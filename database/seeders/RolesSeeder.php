<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

               $permissions = Permission::all();
        $role->syncPermissions($permissions);
    $user=  User::create([

    'name'=>'samir',
   'email'=>'samir@gamil.com',
  'password'=> Hash::make('12345678'),


    ]);

  $user->assignRole('admin');







    }}

