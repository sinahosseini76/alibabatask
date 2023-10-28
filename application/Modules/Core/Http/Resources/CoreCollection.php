<?php

namespace Modules\Core\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class CoreCollection extends ResourceCollection
{
    protected $message;

    public function __construct($response , $message)
    {
        parent::__construct($response);
        $this->message = $message;
    }

    public function with($request): array
    {
        return [
            'status'  => trans('core::response.success') ,
            'message' => $this->message
        ];
    }
}
