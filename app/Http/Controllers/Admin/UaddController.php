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
            return zengjia($request);
        }
    }
}
