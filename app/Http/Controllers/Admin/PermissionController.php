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
        $datainfo = re_jiemi($request);
//        $info  =$datainfo[0];
        $token = $datainfo[1];
        $routeList=getRouthList();
//        $cnt = count($routeList);
      return re_jiami(200,$routeList,$token);
    }

    }

}