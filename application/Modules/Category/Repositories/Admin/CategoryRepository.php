<?php

namespace Modules\Category\Repositories\Admin;

use Modules\Core\Models\Attachment;
use Modules\Core\Repositories\CoreRepository;
use Modules\Category\Models\Category;
use Modules\Category\Models\Product;
use Modules\Category\Models\ProductAdditive;
use Modules\Category\Models\Unit;

class CategoryRepository extends CoreRepository
{

    public function index($request)
    {
        return Category::query()
            ->when($request->has('filter'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->filter . '%');
                $query->orWhere('name_fa', 'like', '%' . $request->filter . '%');
            })
            ->latest()
            ->paginate(10);

    }

    public function getCategories()
    {
        return Category::where('parent_id',null)->get();
    }

    public function store($request)
    {
        $category = Category::create($request->all());
        if ($request->hasFile('attachment')) {
            Attachment::saveAttachmentFile($category,$request->file('attachment','online-menu-category'),'category');
        }
        return $category;
    }

    public function update($category, $request)
    {
        $before = $category->toArray();
        if ($request->hasFile('attachment')) {
            $category->attachments()->delete();
            Attachment::saveAttachmentFile($category,$request->file('attachment','sarvari-product'),'product');
        }

         $category->update([
            'name' => $request->name,
            'name_fa' => $request->name_fa,
            'description' => $request->description,
            'description_fa' => $request->description_fa,
            'status' => isset($request->status) ? $request->status : 'inactive',
            'priority' => $request->priority,
            'parent_id' => $request->parent_id,
         ]);
        $after = Category::find($before['id']);




        return $category;
    }


    public function destroy($category)
    {
        return $category->delete();
    }


    public function changeStatus($category)
    {
        $category->status = $category->status === Category::STATUS_ACTIVE ? Category::STATUS_INACTIVE : Category::STATUS_ACTIVE;
        $category->save();
        return $category;
    }

}
