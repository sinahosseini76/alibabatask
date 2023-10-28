<?php

namespace Modules\Article\Database\seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ArticlePermissionSeeder extends Seeder
{
//    use ExampleModuleTrait;

    public function run()
    {
        $permissions = [
            ['name' => 'article-list',
                'description' => 'List of article',
            ],
            ['name' => 'article-create',
                'description' => 'Create new article',
            ],
            ['name' => 'article-edit',
                'description' => 'edit article',
            ],
            ['name' => 'article-delete',
                'description' => 'delete article',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }



}
