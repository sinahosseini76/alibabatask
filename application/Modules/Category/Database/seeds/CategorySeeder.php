<?php

namespace Modules\Category\Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Core\Models\Attachment;
use Modules\Category\Models\Category;
use Modules\Category\Models\Product;
use Modules\Category\Models\ProductAdditive;
use Modules\Category\Models\Shop;
use Modules\Category\Models\Table;
use Modules\Category\Models\Unit;
use Spatie\Permission\Models\Permission;

class CategorySeeder extends Seeder
{
//    use ExampleModuleTrait;

    public function run()
    {
        $categories = [
            [
                'name' => 'Scientific',
                'name_fa' => 'علمی',
                'description' => 'Scientific',
                'description_fa' => 'مقاله علمی',
                'priority' => 0,
                'parent_id' => null,
            ],
            [
                'name' => 'News',
                'name_fa' => 'اخبار',
                'description' => 'News',
                'description_fa' => 'اخبار',
                'priority' => 0,
                'parent_id' => null,
            ],
            [
                'name' => 'National',
                'name_fa' => 'طبیعت',
                'description' => 'National',
                'description_fa' => 'طبیعت',
                'priority' => 0,
                'parent_id' => null,
            ],
        ];

        Category::query()
            ->insert($categories);

        foreach (Category::all() as $category) {
            $file = File::files(public_path('assets/fake/cat'))[rand(0, 2)];
            // make $file instance of UploadedFile
            $file = new UploadedFile($file, $file->getFilename(), $file->getExtension(), null, true);
            Attachment::saveAttachmentFile($category,$file,'category');
        }



    }


}
