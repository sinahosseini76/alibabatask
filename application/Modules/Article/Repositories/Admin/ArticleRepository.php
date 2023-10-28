<?php

namespace Modules\Article\Repositories\Admin;

use Modules\Article\Models\Article;
use Modules\Category\Models\Category;
use Modules\Core\Models\Attachment;
use Modules\Core\Repositories\CoreRepository;

class ArticleRepository extends CoreRepository
{

    public function publicIndex($request)
    {
        return Article::query()
            ->where('status',Article::STATUS_PUBLISHED)
            ->whereHas('category',function ($query) use ($request){
                $query->where('status',Category::STATUS_ACTIVE);
            })
            ->latest()
            ->paginate(5);
    }


    public function publicShow($articleId)
    {
        $article = Article::query()
            ->where('id',$articleId)
            ->where('status',Article::STATUS_PUBLISHED)
            ->whereHas('category',function ($query){
                $query->where('status',Category::STATUS_ACTIVE);
            })
            ->firstOrFail();

        $article->category->update([
            'view' => $article->category->view + 1
        ]);

        $article->update([
            'view' => $article->view + 1
        ]);
        return $article;
    }

    public function index($request)
    {
        return Article::query()
            ->when($request->has('filter'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->filter . '%');
                $query->orWhere('title_fa', 'like', '%' . $request->filter . '%');
                $query->orWhere('author_name', 'like', '%' . $request->filter . '%');
            })
            ->latest()
            ->paginate(10);

    }

    public function getCategories()
    {
        return Category::all();
    }


    public function store($request)
    {
        $request->merge([
            'admin_id' => auth()->user()->id,
        ]);
        $article = Article::create($request->all());
        if ($request->hasFile('attachment')) {
            Attachment::saveAttachmentFile($article,$request->file('attachment','article'),'article');
        }
        return $article;
    }

    public function update($article, $request)
    {
        if ($request->hasFile('attachment')) {
            $article->attachments()->delete();
            Attachment::saveAttachmentFile($article,$request->file('attachment','article'),'article');
        }

         $article->update([
            'title' => $request->title,
            'title_fa' => $request->title_fa,
            'body' => $request->body,
            'body_fa' => $request->body_fa,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'author_name' => $request->author_name,
            'publish_at' => $request->publish_at,
         ]);




        return $article;
    }


    public function destroy($article)
    {
        return $article->delete();
    }


}
