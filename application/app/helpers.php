<?php

use Illuminate\Support\Facades\Auth;

function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function active_class_with_route($route, $active = 'active') {
  return call_user_func_array('Route::is', (array)$route) ? $active : '';
}

function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function getModuleViewPath($module): string
{
  return str_replace('/app', '', app_path('Modules/'.$module.'/resources/views'));
}

function getModuleApiRoutePath($module): string
{
    return base_path("Modules/$module/Routes/api.php");
}






function checkAcl($permission)
{
  return auth()->user()->can($permission);
}
