<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Manager;
use App\Http\Models\Permission;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 角色列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
    if ($request->isMethod('post'))
//        $datainfo= qingqiu_jiami($request);
//        $shujk = orm_sjk($datainfo[3]);
//        if( !is_object ($shujk)){
//            return  wei_jiami(500,['err'=>'未找到查询数据库的字段']);
//        }
//        $jiansuo = $datainfo[9];
//        $created_at = $datainfo[10];
//
//        if(!is_null($datainfo[4]) && !empty($datainfo[5])){
//            $shuju = $shujk->offset($datainfo[4])
//                ->limit($datainfo[5])
//                ->orderBy($datainfo[6], $datainfo[7])
//                ->with($datainfo[1])
//                ->where(function($query) use($request,$jiansuo){
//                    foreach ($jiansuo as $k => $v){
//                        if (!empty($v)){
//                            //新修改1 加上数组检索
//                            if(is_array($v)){
//                                $query->whereIn($k,$v);
//                            }else{
//                                $query->where($k, $v);
//                            }
//                        }
//                    }
//                })
//                ->where(function ($query) use($request,$created_at){
//                    if ( !empty($created_at)){
//                        $query->whereBetween('created_at',$created_at);
//                    }
//                })
//                ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
//        }else{
//            $shuju =$shujk->orderBy($datainfo[6], $datainfo[7])
//                ->with($datainfo[1])
//                ->where(function($query) use($request,$jiansuo){
//                    foreach ($jiansuo as $k => $v){
//                        if (!empty($v)){
//                            //新修改1 加上数组检索
//                            if(is_array($v)){
//                                $query->whereIn($k,$v);
//                            }else{
//                                $query->where($k, $v);
//                            }
//                        }
//                    }
//                })
//                ->where(function ($query) use($request,$created_at){
//                    if ( !empty($created_at)){
//                        $query->whereBetween('created_at',$created_at);
//                    }
//                })
//                ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
//        }
//        //添加额外的字段
//
////        foreach ($shuju as $k=>$v){
////            foreach ($datainfo[1] as $kk => $vv){
////                if(isset($v->$vv) && !empty($v->$vv)){
////                    $userinfo=$v->$vv->toArray();
////                    unset($shuju[$k][$vv]);
////                    $d = test_odd($userinfo,$datainfo[2]);
////                    $shuju[$k][$vv] = $d;
////                }
////            }
////        }
//                foreach ($shuju as $k=>$v){
//                    $ps_ids = explode(',',$v['ps_ids']);
//                    $route = Permission::select('ps_name','ps_route')->whereIn('ps_id',$ps_ids)->get()->toArray();
//                    foreach ($route as $kk => $vv){
//                             $routes[$kk]['ps_name'] = $vv['ps_name'];
//                            $routes[$kk]['ps_route'] = explode(',',$vv['ps_route']);
//                    }
//                    $shuju[$k]['route'] =$routes;
//
//                    $mg_ids=Manager::select('mg_id')->where('role_id',$k+1)->get()->toArray();
//                    $shuju[$k]['mg_ids'] =$mg_ids;
//                }
//
//
//        return re_jiami(200,$shuju,$datainfo[11],$datainfo[12]);
        return jiami_shousuo($request);
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


    /**
     * 修改角色(分配权限)
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            return shanchu($request);
        }
    }
}