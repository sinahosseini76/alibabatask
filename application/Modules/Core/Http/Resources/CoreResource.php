<?php

namespace Modules\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoreResource extends JsonResource
{
    protected  $message;

    public function __construct($response , $message)
    {
        parent::__construct($response);
        $this->message = $message;
    }

    public function with($request)
    {
        return [
            'status'  => trans('core::response.success') ,
            'message' => $this->message
        ];
    }
}
