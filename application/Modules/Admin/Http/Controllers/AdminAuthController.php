<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Modules\Admin\Http\Requests\OtpRequest;
use Modules\Admin\Lib\SMSIR;
use Modules\Admin\Models\Admin;
use Modules\Admin\Services\AdminService;
use Modules\Core\Http\Controllers\CoreController;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminAuthController extends CoreController
{
    use AuthenticatesUsers;

    public function __construct(AdminService $adminService)
    {
        $this->service = $adminService;
    }

    public function getLogin(){
        return view('auth.login');
    }

    public function adminLoginOtp(){
        return view('auth.otp');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        //admin guard login
        if (auth()->attempt(array(
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ))) {
            if(! auth()->user()->isRoleActive()){
                return redirect()->route('error.403');
            }
            auth('admin')->user()->last_login = Carbon::now();
            auth('admin')->user()->save();
            return redirect()->route('adminDashboard');
        }

        return back()->with('error','Whoops! invalid email and password.');
    }

    public function Logout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }


    public function dashboard()
    {
        $adminsCount = $this->service->adminsCount();
        $categoriesCount = $this->service->categoriesCount();
        $articlesCount = $this->service->articlesCount();
        $viewsCount = $this->service->viewsCount();
        return view('dashboard', compact('adminsCount', 'categoriesCount', 'articlesCount', 'viewsCount'));
    }

}
