<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\Admin\ArticleController;
use Modules\Category\Http\Controllers\Admin\CategoryController;
use Modules\Category\Http\Controllers\Admin\ProductController;

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['web', 'auth.admin']
], function () {
        Route::group([
            'prefix' => '/article',
            'as' => 'article.'
        ], function () {
            Route::get('/', [ArticleController::class, 'index'])->name('index');
            Route::get('/{article}/show', [ArticleController::class, 'show'])->name('show');
            Route::get('/create', [ArticleController::class, 'create'])->name('create');
            Route::post('/', [ArticleController::class, 'store'])->name('store');
            Route::post('/{article}/update', [ArticleController::class, 'update'])->name('update');
            Route::get('/change-status', [ArticleController::class, 'changeStatus'])->name('changeStatus');
            Route::get('/{article}/delete', [ArticleController::class, 'destroy'])->name('destroy');
            Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        });

});

Route::get('/', [ArticleController::class, 'publicIndex'])->name('article.public.index');
Route::get('/article/{article}', [ArticleController::class, 'publicShow'])->name('article.public.show');
