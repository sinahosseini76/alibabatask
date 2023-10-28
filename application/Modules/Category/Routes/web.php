<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Admin\CategoryController;
use Modules\Category\Http\Controllers\Admin\ProductController;

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['web', 'auth.admin']
], function () {

        Route::group([
            'prefix' => '/category',
            'as' => 'category.'
        ], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/{category}/show', [CategoryController::class, 'show'])->name('show');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::post('/{category}/update', [CategoryController::class, 'update'])->name('update');
            Route::get('/change-status/{category}', [CategoryController::class, 'changeStatus'])->name('changeStatus');
            Route::get('/{category}/delete', [CategoryController::class, 'destroy'])->name('destroy');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        });

});
