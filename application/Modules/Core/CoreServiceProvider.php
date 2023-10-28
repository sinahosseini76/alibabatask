<?php

namespace Modules\Core;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Exceptions\CoreException;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @throws CoreException
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        //register config file
        $this->registerConfig();

        //register core view
        $this->loadViewsFrom(__DIR__ . '/resources/views' , 'Core');

        //register all modules
        $this->registerModules();

        //register commands from config
        $this->commands(config('coreServices.commands'));

        //load language
        $this->registerLang();

        //register middleware
        $this->registerMiddleware();

        //render handler exception
        $this->registerExceptionHandler();

    }

    private function registerLang()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang' , 'core');
        $modules = config('modules');
        foreach ($modules as $key => $module) {
            if ($module['status']) {
                $this->loadTranslationsFrom(base_path($module['services']['lang']['path']) , $module['services']['lang']['name']);
            }
        }
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/modules.php' , 'modules');
        $this->mergeConfigFrom(__DIR__ . '/Config/services.php' , 'coreServices');
        $this->mergeConfigFrom(__DIR__ . '/Config/shop.php' , 'shop');
    }

    /**
     * @throws CoreException
     */
    private function registerModules()
    {
        $loaded = [];
        $modules = config('modules');
        $allModules = array_keys(array_filter($modules , function ($module) {
            return $module['status'];
        }));
        foreach ($modules as $key => $module) {
            if ($module['status']) {
                if (isset($module['dependencies']) && !empty($module['dependencies'])) {
                    foreach ($module['dependencies'] as $dependency) {
                        if (!in_array($dependency , $loaded) && !in_array($dependency , $allModules)) {
                            throw new CoreException("Module {$key} depends on {$dependency} but {$dependency} is not loaded");
                        }
                    }
                }
                $this->app->register($module['services']['provider']);
                $this->loadViewsFrom(base_path($module['view']['path']) , $module['name']);
                $loaded[] = $key;
            }
        }
        Cache::forever('modules' , $loaded);
    }

    private function registerMiddleware()
    {
        //register middleware
        $this->app['router']->aliasMiddleware('translate' , Http\Middleware\Translate::class);

        $this->app['router']->aliasMiddleware('bindings' , \Illuminate\Routing\Middleware\SubstituteBindings::class);


        //register middleware group
        $this->app['router']->middlewareGroup('api' , [
            'translate' ,
            'bindings' ,
        ]);
    }

    private function registerExceptionHandler()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class ,
            \Modules\Core\Exceptions\Handler::class
        );
    }


}
