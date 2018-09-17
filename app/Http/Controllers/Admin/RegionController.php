<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class RegionController extends Controller
{

    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {

        if ($request->isMethod("post")) {
            return shousuo($request);
        }
    }

    /**
     * 修改培养信息
     * @param Request $request
     * @param Region $User
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
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')){
            return zengjia($request);
        }
    }
}
