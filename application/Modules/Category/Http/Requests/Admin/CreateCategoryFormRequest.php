<?php

namespace Modules\Category\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:64',
            'name_fa' => 'required|max:64',
            'description' => 'nullable|max:255',
            'description_fa' => 'nullable|max:255',
            'status' => 'nullable|in:active,inactive',
            'priority' => 'required|numeric|min:0',
            'parent_id' => 'nullable|exists:category,id',
        ];
    }

    public function messages()
    {
        return [];
    }
}
