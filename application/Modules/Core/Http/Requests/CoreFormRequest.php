<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class CoreFormRequest extends FormRequest
{
    protected Model $model;

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return $this->prepareRules();
    }

    public function messages(): array
    {
        $messages = [];
        foreach ($this->model::RULES as $key => $value) {
            $values = explode('|' , $value);
            foreach ($values as $item) {
                $model = strtolower(class_basename($this->model));
                if (str_contains($item , 'unique:') || str_contains($item , 'exists:')) {
                    $item = explode(':' , $item)[0];
                    $messages[$key . '.' . $item] = trans(
                        $model . '::validation.' . $key . '.' . $item ,
                        ['attribute' => $key]
                    );
                } else if (str_contains($item , 'in:')) {
                    $options = explode(',' , str_replace('in:' , '' , $item));
                    $item = explode(':' , $item)[0];
                    $messages[$key . '.' . $item] = trans(
                        $model . '::validation.' . $key . '.' . $item ,
                        ['attribute' => $key , 'values' => implode(' , ' , $options)]
                    );
                } else {
                    $messages[$key . '.' . $item] = trans(
                        $model . '::validation.' . $key . '.' . $item ,
                        ['attribute' => $key]
                    );
                }

            }
        }
        return $messages;
    }

    protected function prepareRules()
    {
        $parameter = 0;
        $params = $this->route()->parameterNames;
        if (count($params) > 0) {
            foreach ($params as $param) {
                $parameter = $this->route()->parameter($param);
                if (in_array($param , $this->model->getFillable())) {
                    $parameter = $this->model->where($param , $parameter)->first();
                    if ($parameter) {
                        $parameter = $parameter->id;
                    }
                }
            }
        }
        $rules = $this->model::RULES;
        foreach ($rules as $key => $rule) {
            $rules[$key] = str_replace('{{param}}' , $parameter , $rule);
        }
        return $rules;
    }
}
