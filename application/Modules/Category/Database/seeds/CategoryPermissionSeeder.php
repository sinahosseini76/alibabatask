<?php

namespace Modules\Category\Database\seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CategoryPermissionSeeder extends Seeder
{
//    use ExampleModuleTrait;

    public function run()
    {
        $permissions = [
            ['name' => 'category-list',
                'description' => 'List of category',
            ],
            ['name' => 'category-create',
                'description' => 'Create new category',
            ],
            ['name' => 'category-edit',
                'description' => 'edit category',
            ],
            ['name' => 'category-delete',
                'description' => 'delete category',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }



}
