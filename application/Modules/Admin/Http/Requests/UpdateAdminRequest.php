<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,'.$this->admin->id,
            'email' => 'required|string|max:255|unique:admins,email,'.$this->admin->id,
            'phone' => 'required|string|max:255|unique:admins,phone,'.$this->admin->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|string|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [];
    }
}
