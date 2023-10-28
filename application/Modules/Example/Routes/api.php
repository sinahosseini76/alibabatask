<?php

use Illuminate\Support\Facades\Route;
use Modules\Example\Http\Controllers\{
    DashboardController
};

Route::group(['prefix' => 'api/example', 'middleware' => ['auth:api', 'role:customerAdmin|supplierAdmin']], function () {
});
