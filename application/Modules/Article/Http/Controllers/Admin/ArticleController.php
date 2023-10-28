<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Article\Http\Requests\Admin\CreateArticleFormRequest;
use Modules\Article\Models\Article;
use Modules\Article\Services\Admin\ArticleService;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Category\Http\Requests\Admin\CreateCategoryFormRequest;
use Modules\Category\Models\Category;
use Modules\Category\Services\Admin\CategoryService;
use Modules\Ticket\Http\Requests\Admin\CreateDepartmentFormRequest;
use Modules\Ticket\Models\Department;
use Modules\Ticket\Services\Admin\DepartmentService;

class ArticleController extends CoreController
{
    public function __construct(ArticleService $articleService)
    {
        $this->middleware('permission:article-list|article-create|article-edit|article-delete', ['only' => ['index','store']]);
        $this->middleware('permission:article-create', ['only' => ['create','store']]);
        $this->middleware('permission:article-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:article-delete', ['only' => ['destroy']]);
        $this->service = $articleService;
    }

    public function publicIndex(Request $request)
    {
        return $this->service->publicIndex($request);
    }

    public function publicShow()
    {
        return $this->service->publicShow(request()->route()->parameters()['article']);
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(CreateArticleFormRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Article $article)
    {
        if($article->admin_id != auth()->user()->id){
            session()->flash('error-message', 'شما اجازه ویرایش این مقاله را ندارید');
            return redirect()->route('article.index');
        }
        return $this->service->edit($article);
    }

    public function update(Article $article,CreateArticleFormRequest $request)
    {
        return $this->service->update($article,$request);
    }

    public function destroy(Article $article)
    {
        return $this->service->destroy($article);
    }


}
