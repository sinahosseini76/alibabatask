<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminAuthController;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\PermissionController;
use Modules\Admin\Http\Controllers\RoleController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Example\Http\Controllers\{DashboardController};

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['web']
], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::get('/login/otp', [AdminAuthController::class, 'adminLoginOtp'])->name('adminLoginOtp');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    Route::get('/logout', [AdminAuthController::class, 'Logout'])->name('adminLogOut');

    Route::post('/otp', [AdminAuthController::class, 'sendOtp'])->name('adminSendOtp')->middleware('throttle:5,1');

    Route::group([
        'middleware' => 'auth.admin'
    ], function () {
//        Route::resource('roles', RoleController::class);
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('adminDashboard');
        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::post('/admins/{admin}/update', [AdminController::class, 'update'])->name('admins.update');
        Route::get('/admins/{admin}/delete', [AdminController::class, 'destroy'])->name('admins.destroy');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');


        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}/show', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::post('/roles/{role}/update', [RoleController::class, 'update'])->name('roles.update');
        Route::get('/roles/change-status', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
        Route::get('/roles/{role}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');

        Route::get('/permissions', [PermissionController::class, 'index']);



    });
});
