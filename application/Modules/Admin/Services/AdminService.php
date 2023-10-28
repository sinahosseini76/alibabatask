<?php

namespace Modules\Admin\Services;

use Modules\Admin\Repositories\AdminRepository;
use Modules\Core\Services\CoreService;

class AdminService extends CoreService
{
    public function __construct(AdminRepository $adminRepository)
    {
        $this->repository = $adminRepository;
    }

    public function index($request)
    {
        $admins = $this->repository->index($request);
        return view('pages.admin-index', compact('admins'));
    }

    public function create()
    {
        $roles = $this->repository->getRoles();
        return view('pages.admin-create',compact('roles'));
    }

    public function store($request)
    {
        $admin = $this->repository->store($request);
        if (!$admin) {
            session()->flash('error-message', 'Admin Created Failed');
        }
        session()->flash('success-message', 'Admin Created Successfully');
        return redirect()->route('admins.index');
    }

    public function edit($admin)
    {
        $roles = $this->repository->getRoles();
        return view('pages.admin-edit', compact('admin','roles'));
    }

    public function update($admin,$request)
    {
        $result = $this->repository->update($admin, $request);
        if(!$result){
            session()->flash('error-message', 'Admin not updated');
        }
        session()->flash('success-message', 'Admin updated successfully');
        if($request->has('password') && $request->password != null){
            $res =  $this->repository->resetPassword($admin, $request);
            if(!$result){
                session()->flash('error-message', 'Can Not Reset Password');
            }else{
                session()->flash('success-message', 'Password Reset Successfully and Admin updated successfully');
            }
        }
        return redirect()->route('admins.index');
    }




    public function destroy($admin)
    {
        $result = $this->repository->destroy($admin);
        if($result){
            session()->flash('swal-success-message', 'Admin deleted successfully');
            return response(['message' => 'Admin deleted successfully']);
        }
        return response(['message' => 'Admin Can Not deleted'],500);
    }

    public function adminsCount()
    {
        return $this->repository->adminsCount();
    }
    public function categoriesCount()
    {
        return $this->repository->categoriesCount();
    }
    public function articlesCount()
    {
        return $this->repository->articlesCount();
    }
    public function viewsCount()
    {
        return $this->repository->viewsCount();
    }

}
