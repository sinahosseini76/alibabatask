<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Modules\Core\Exceptions\CoreException;

class Translate
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$guards
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request , Closure $next , ...$guards)
    {
        if ($request->header('Accept-Language')) {
            //validate language get en ,fa
            //TODO need to make other language
            if (!in_array($request->header('Accept-Language') , ['en' , 'fa'])) {
                app()->setLocale(config('app.locale'));
            }
            app()->setLocale($request->header('Accept-Language'));
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
