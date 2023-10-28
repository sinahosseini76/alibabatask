<?php

namespace Modules\Article\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Article\Models\Article;

class CreateArticleFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:64',
            'title_fa' => 'required|max:64',
            'body' => 'required|max:4096',
            'body_fa' => 'required|max:4096',
            'status' => 'required|in:'.Article::STATUS_PENDING.','.Article::STATUS_PUBLISHED.','.Article::STATUS_DRAFT,
            'category_id' => 'required|exists:category,id',
        ];
    }

    public function messages()
    {
        return [];
    }
}
