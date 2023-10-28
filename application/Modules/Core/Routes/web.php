<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return redirect(route('adminDashboard'));
//});

use Modules\Article\Http\Controllers\Admin\ArticleController;
use Modules\Core\Http\Controllers\AttachmentController;

Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); })->name('error.404');
    Route::get('403', function () { return view('pages.error.403'); })->name('error.403');
    Route::get('500', function () { return view('pages.error.500'); })->name('error.500');
});


Route::get('v1/auth/login', function () { return redirect()->route('adminLogin'); });



Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['web','auth.admin']
], function () {
    Route::group([
        'prefix' => '/attachments',
    ], function () {
        Route::get('/{attachment}', [AttachmentController::class, 'destroy'])->name('attachment.destroy');
        Route::post('/upload', [AttachmentController::class, 'upload'])->name('attachment.upload');
    });

});

