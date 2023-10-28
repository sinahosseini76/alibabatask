<?php

namespace Modules\Admin\Database\seeds;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::query()->create([
            'first_name' => 'admin' ,
            'last_name'  => 'admin' ,
            'username'   => 'admin' ,
            'phone'      => '09001231111' ,
            'email'      => 'admin@gmail.com' ,
            'password'   => 'admin' ,
        ]);

        $role = Role::create(['name' => 'SuperAdmin']);

        $permissions = Permission::pluck('id' , 'id')->all();

        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);


        $author = Admin::query()->create([
            'first_name' => 'author' ,
            'last_name'  => 'author' ,
            'username'   => 'author' ,
            'phone'      => '09001231122' ,
            'email'      => 'author@gmail.com' ,
            'password'   => 'user' ,
        ]);

        $role = Role::create(['name' => 'Author']);

        $permissions = Permission::pluck('id' , 'id')->all();

        $role->syncPermissions($permissions);

        $author->assignRole([$role->id]);

    }
}
