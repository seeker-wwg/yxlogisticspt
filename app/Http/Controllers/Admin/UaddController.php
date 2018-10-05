<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Uadd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UaddController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod("post")) {
             return jiami_shousuo($request);
        }
    }



    /**
     * 修改用户地址信息
     * @param Request $request
     * @param Uadd $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            return xiugai($request);
        }
    }

    /**
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        if ($request->isMethod('post')){
            return shanchu($request);
        }
    }


    /**
     * 添加用户地址信息
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $sjk = $info['sjk'];
            $ziyuan = orm_sjk($sjk);
            $formData = $info['formData'];

            if(array_key_exists('password', $formData)){
                $formData['password'] = bcrypt($formData['password']);
            }
            if(!empty($zdy_kv)){
                foreach ($zdy_kv as $k => $v){
                    $formData[$k] = $v;
                }
            }
            if( !is_object ($ziyuan)){
                return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
            }
            $z = $ziyuan->create($formData);
            if ($z) {
                $shuju = ['errorinfo'=>'增加成功','uadd_id'=>$z->uadd_id];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'增加失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }
}
