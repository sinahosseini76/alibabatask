<?php

namespace Modules\Category;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
