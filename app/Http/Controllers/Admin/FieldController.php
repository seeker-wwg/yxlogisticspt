<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    /**
     * 单一字段列表
     * @param Request $request
     */
    public function index(Request $request)
    {
            if ($request->isMethod("post")) {
                return shousuo($request);
            }
    }


    /**
     * 修改平台运输车辆信息
     * @param Request $request
     * @param Field $Field
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            return  xiugai($request);
        }
    }


    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            return  shanchu($request);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return  zengjia($request);
        }
    }
}
