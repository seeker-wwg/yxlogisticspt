<?php

namespace App\Http\Controllers\Admin;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return jiami_shousuo($request);
        }
    }


    /**
     * 修改角色(分配权限)
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            return xiugai($request);
        }
    }

    /**
     * 修改角色(分配权限)
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return zengjia($request);
        }
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            return shanchu($request);
        }
    }


}