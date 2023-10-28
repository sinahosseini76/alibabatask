<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Category\Http\Requests\Admin\CreateCategoryFormRequest;
use Modules\Category\Models\Category;
use Modules\Category\Services\Admin\CategoryService;
use Modules\Ticket\Http\Requests\Admin\CreateDepartmentFormRequest;
use Modules\Ticket\Models\Department;
use Modules\Ticket\Services\Admin\DepartmentService;

class CategoryController extends CoreController
{
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->service = $categoryService;
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(CreateCategoryFormRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Category $category)
    {
        return $this->service->edit($category);
    }

    public function update(Category $category,CreateCategoryFormRequest $request)
    {
        return $this->service->update($category,$request);
    }

    public function destroy(Category $category)
    {
        return $this->service->destroy($category);
    }

    public function changeStatus(Category $category)
    {
        return $this->service->changeStatus($category);
    }

}
