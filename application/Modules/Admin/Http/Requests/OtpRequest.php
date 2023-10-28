<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       // if route name is adminLoginOtp then otp is required
        if($this->route()->getName() == 'adminSendOtp'){
            return [
                'phone' => 'required|string',
            ];
        }
        return [
            'phone' => 'required|string',
            'code' => 'required|string|min:4|max:4',
        ];
    }

    public function messages()
    {
        return [];
    }
}
