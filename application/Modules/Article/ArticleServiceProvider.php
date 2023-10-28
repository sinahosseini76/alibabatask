<?php

namespace Modules\Article;

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
