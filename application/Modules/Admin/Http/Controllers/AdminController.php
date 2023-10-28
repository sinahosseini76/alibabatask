<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\CreateAdminRequest;
use Modules\Admin\Http\Requests\UpdateAdminRequest;
use Modules\Admin\Models\Admin;
use Modules\Admin\Services\AdminService;
use Modules\Core\Http\Controllers\CoreController;

class AdminController extends CoreController
{
    public function __construct(AdminService $adminService)
    {
        $this->service = $adminService;
        $this->middleware('permission:admin-list', ['only' => ['index']]);
        $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update','changeStatus']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        return $this->service->index($request);
    }


    public function create()
    {
        return $this->service->create();
    }

    public function store(CreateAdminRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Admin $admin)
    {
        return $this->service->edit($admin);
    }

    public function update(Admin $admin,UpdateAdminRequest $request)
    {
        return $this->service->update($admin,$request);
    }


    public function destroy(Admin $admin)
    {
        return $this->service->destroy($admin);
    }
}
