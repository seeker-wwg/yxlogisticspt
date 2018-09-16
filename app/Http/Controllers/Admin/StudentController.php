<?php

namespace App\Http\Controllers\Admin;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * 角色列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
    if ($request->isMethod('post')){
        $routeList=getRouthList();
        $cnt = count($routeList);
        $info = encrypt_pass(serialize([
            'status' => 200,
            'recordsTotal' => $cnt,
            'data' => $routeList,
        ]),cut_token(session('_token')));
        return $info;
    }

    }

}