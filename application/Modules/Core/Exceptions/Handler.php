<?php

namespace Modules\Core\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Core\Traits\CoreApiResponser;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use CoreApiResponser;

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request , Throwable $e)
    {
        if ($request->header('Accept-Language')) {
            if (!in_array($request->header('Accept-Language') , ['en' , 'fa'])) {
                app()->setLocale(config('app.locale'));
            }
            app()->setLocale($request->header('Accept-Language'));
        } else {
            app()->setLocale(config('app.locale'));
        }

        if ($e instanceof ValidationException && $request->expectsJson()) {
            return $this->errorResponse(['errors' => $e->validator->getMessageBag()] , 'Incorrect data' , 422);
        }

        if ($e instanceof CoreException && $request->expectsJson()) {
            return $this->errorResponse([] , $e->getMessage() , $e->getCode());
        }

        /*
         * Handle Throttle Requests Exception with translation
         */
        if ($e instanceof ThrottleRequestsException && $request->expectsJson()) {
            return $this->errorResponse([] , trans('core::messages.exception.throttle' , ['seconds' => $e->getHeaders()['Retry-After']]) , 429);
        }

        if ($e instanceof NotFoundHttpException && $request->expectsJson()) {
            return $this->errorResponse([] , trans('core::messages.exception.not_found' , ['url' => $request->url()]) , 404);
        }

        if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return $this->errorResponse([] , trans('core::messages.exception.model_not_found') , 404);
        }

        if ($e instanceof AuthenticationException && $request->expectsJson()) {
            return $this->errorResponse([] , trans('core::messages.exception.unauthenticated') , 401);
        }

        if ($e instanceof MethodNotAllowedException && $request->expectsJson()) {
            return $this->errorResponse([] , trans('core::messages.exception.method_not_allowed') , 405);
        }

        if ($e instanceof HttpException && $e->getStatusCode() == 403) {
            return  redirect()->route('error.403');
            return $this->errorResponse([] , trans('core::messages.exception.forbidden') , 403);
        }

        if ($e instanceof UnauthorizedException) {
            return redirect()->route('error.403');
        }

        if ($e instanceof ModelNotFoundException && $request->isJson()) {
            return response()->json(['status' => 'failed' , 'message' => 'Record Not Found' , 'data' => []] , 404);
        }

        if ($e->getCode() == 0) {
//            dispatch(
//                new AuditLogJob(
//                    $request->except(
//                        ['avatar' , 'attachments' , 'attachment']) ,
//                    $request->headers->all() ,
//                    $request->ip() ,
//                    null ,
//                    null ,
//                    AuditLog::ACTION_TYPE_EXCEPTION ,
//                    500 ,
//                    ['exception' => $e->getMessage()]
//                )
//            );
        }

        return parent::render($request , $e);
    }

}
