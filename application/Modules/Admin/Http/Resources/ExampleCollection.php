<?php

namespace Modules\Example\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Dashboard\Http\Resources\DashboardHomeResource;


class ExampleCollection extends ResourceCollection
{
    private $message;

    public function __construct($response, $message)
    {
        parent::__construct($response);
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return new DashboardHomeResource($item, 'Example received successfully');
            })
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'message' => $this->message
        ];
    }
}
