<?php

namespace Modules\Article\Services\Admin;

use Modules\Article\Repositories\Admin\ArticleRepository;
use Modules\Core\Services\CoreService;

class ArticleService extends CoreService
{
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->repository = $articleRepository;
    }

    public function publicIndex($request)
    {
        $articles = $this->repository->publicIndex($request);
        return view('article-public', compact('articles'));
    }

    public function publicShow($articleId)
    {
        $article = $this->repository->publicShow($articleId);
        return view('article-public-details', compact('article'));
    }

    public function index($request)
    {
        $articles = $this->repository->index($request);
        return view('article-index', compact('articles'));
    }


    public function create()
    {
        $categories = $this->repository->getCategories();
        return view('article-create',compact('categories'));
    }

    public function store($request)
    {
        $article = $this->repository->store($request);
        if (!$article) {
            session()->flash('error-message', 'Article Created Failed');
        }
        session()->flash('success-message', 'Article Created Successfully');
        return redirect()->route('article.index');
    }


    public function edit($article)
    {
        $categories = $this->repository->getCategories();
        return view('article-edit', compact('article','categories'));
    }

    public function update($article,$request)
    {
        $result = $this->repository->update($article, $request);
        if(!$result){
            session()->flash('error-message', 'Article not updated');
        }
        session()->flash('success-message', 'Article updated successfully');
        return redirect()->route('article.index');
    }

    public function destroy($article)
    {
        $result = $this->repository->destroy($article);
        if($result){
            session()->flash('swal-success-message', 'Article deleted successfully');
            return response(['message' => 'Article deleted successfully']);
        }
        return response(['message' => 'Article Can Not deleted'],500);
    }






}
