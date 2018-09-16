<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\OrderVeh;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrucksController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod("post")) {

            return jiami_shousuo($request);
        }
    }

    /**
     * 修改培养信息
     * @param Request $request
     * @param OrderVeh $User
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
            $order_veh_ids = $request->input('order_veh_ids');
            $z = DB::table('order_veh')->whereIn('order_veh_id',$order_veh_ids)->delete();
            if ($z) {
                return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
            } else {
                return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'删除失败']),cut_token(session('_token')));
            }
        }

    }
}
