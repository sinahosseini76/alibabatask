<?php

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Admin;
use Modules\Article\Models\Article;
use Modules\Category\Models\Category;
use Modules\Core\Repositories\CoreRepository;
use Spatie\Permission\Models\Role;

class AdminRepository extends CoreRepository
{
    public function index($request)
    {
        return Admin::query()
            ->when($request->has('filter') , function ($q) use ($request){
                $q->where('first_name', 'like', '%' . $request->filter . '%');
                $q->Orwhere('last_name', 'like', '%' . $request->filter . '%');
                $q->Orwhere('username', 'like', '%' . $request->filter . '%');
                $q->Orwhere('phone', 'like', '%' . $request->filter . '%');
                $q->Orwhere('email', 'like', '%' . $request->filter . '%');
            })
            ->latest()
            ->paginate(30);
    }

    public function update($admin, $request)
    {
        $admin->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'role_id' => $request->get('role_id'),
        ]);
        return $admin->syncRoles([$request->role_id]);
    }

    public function resetPassword($admin, $request)
    {
        return $admin->update(['password' => $request->password]);
    }

    public function getRoles()
    {
        return Role::all();
    }



    public function store($request)
    {
        $admin = Admin::create($request->all());
       return $admin->assignRole([$request->role_id]);
    }

    public function destroy($admin)
    {
        $admin->roles()->detach();
        return $admin->delete();
    }

    public function adminsCount()
    {
        return Admin::all()->count() ?? 0;
    }
    public function categoriesCount()
    {
        return Category::all()->count() ?? 0;
    }
    public function articlesCount()
    {
        return  Article::all()->count() ?? 0;
    }
    public function viewsCount()
    {
        return  Article::sum('view') ?? 0;
    }


}
