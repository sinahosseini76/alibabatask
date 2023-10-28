<?php

namespace Modules\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
