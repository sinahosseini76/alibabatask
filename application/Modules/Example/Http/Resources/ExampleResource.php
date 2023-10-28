<?php

namespace Modules\Example\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExampleResource extends JsonResource
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
            'item' => $this->item,
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
