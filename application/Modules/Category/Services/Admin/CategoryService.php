<?php

namespace Modules\Category\Services\Admin;

use Modules\Core\Services\CoreService;
use Modules\Category\Repositories\Admin\CategoryRepository;
use Modules\Category\Repositories\Admin\ProductRepository;

class CategoryService extends CoreService
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function index($request)
    {
        $categories = $this->repository->index($request);
        return view('category-index', compact('categories'));
    }


    public function create()
    {
        $categories = $this->repository->getCategories();
        return view('category-create',compact('categories'));
    }

    public function store($request)
    {
        $category = $this->repository->store($request);
        if (!$category) {
            session()->flash('error-message', 'Category Created Failed');
        }
        session()->flash('success-message', 'Category Created Successfully');
        return redirect()->route('category.index');
    }


    public function edit($category)
    {
        $categories = $this->repository->getCategories();
        return view('category-edit', compact('category','categories'));
    }

    public function update($category,$request)
    {
        $result = $this->repository->update($category, $request);
        if(!$result){
            session()->flash('error-message', 'Category not updated');
        }
        session()->flash('success-message', 'Category updated successfully');
        return redirect()->route('category.index');
    }

    public function destroy($category)
    {
        $result = $this->repository->destroy($category);
        if($result){
            session()->flash('swal-success-message', 'Category deleted successfully');
            return response(['message' => 'Category deleted successfully']);
        }
        return response(['message' => 'Category Can Not deleted'],500);
    }



    public function changeStatus($category)
    {
         $this->repository->changeStatus($category);
        session()->flash('success-message', 'Category Status Changed Successfully');
        return redirect()->back();
    }




}
