<?php

namespace Modules\Admin\Database\seeds;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = json_decode(file_get_contents(__DIR__ . '/permissions.json'), true);
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
