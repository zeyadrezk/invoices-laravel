<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    // Create admin User and assign the role to him.
	    $user = User::create([
		    'name' => 'zozRezk',
		    'email' => 'zizorezk@gmail.com',
		    'password' => Hash::make('123456'),
		    'roles_name' =>[ "owner"],
		    'status' => "مفعل",
	    ]);
	    
	    $role = Role::create(['name' => 'owner']);
	    
	    $permissions = Permission::pluck('id', 'id')->all();
	    
	    $role->syncPermissions($permissions);
	    
	    $user->assignRole([$role->id]);
    }
}
