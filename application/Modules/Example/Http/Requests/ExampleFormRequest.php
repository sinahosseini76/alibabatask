<?php

namespace Modules\Example\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExampleFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item' => 'required',
        ];
    }

    public function messages()
    {
        return [];
    }
}
