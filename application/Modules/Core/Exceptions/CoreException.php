<?php

namespace Modules\Core\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class CoreException extends Exception
{
    /**
     * @var
     */
    protected $message;
    protected $code;

    public function __construct($message = "" , $code = 0 , Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message , $code , $previous);
    }
}
