<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    /**
     * 帮助列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return shousuo($request);
        }
    }




    /**
     * 删除帮助信息
     * @param Request $request
     * @param Banner $Banner
     * @return array
     * @throws \Exception
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
                return zengjia($request);
        }
    }
    /**
     * 修改帮助
     * @param Request $request
     * @param Price $User
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
        if($request->isMethod('post')){
            return shanchu($request);
        }
    }
}
