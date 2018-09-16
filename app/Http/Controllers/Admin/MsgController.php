<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Msg;
use App\Http\models\UserMsg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MsgController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function userid(Request $request)
    {
        if ($request->isMethod("post")) {
           return jiami_shousuo($request);
        }
    }

    /**
     * 获取某一用户的推送消息数目
     * @param Request $request
     * @return array
     *
     */
    public function number(Request $request)
    {
        if ($request->isMethod('post')){

            $user_id = $request->input('user_id');
            $info = UserMsg::where('user_id',$user_id)->get(['status','user_id']);
            $cnt  = count($info);
            $info = encrypt_pass(serialize([
                'status' => 200,
                'recordsTotal' => $cnt,
                'data' => $info,
            ]),cut_token(session('_token')));
            return $info;
        }
    }
    /**
     * 将某一用户的推送消息置为“已读”状态
     * @param Request $request
     * @return array
     *
     */
    public function status(Request $request)
    {
        if ($request->isMethod('post')) {
            $user_id = $request->input('user_id');
            $msg_ids = $request->input('msg_ids');
            $z = UserMsg::where('user_id', $user_id)->whereIn('msg_id', $msg_ids)->update(['status' => '已读']);
            if ($z) {
                return encrypt_pass(serialize(['status' => 200]), cut_token(session('_token')));
            } else {
                return encrypt_pass(serialize(['status' => 500, 'errorinfo' => '更改失败']), cut_token(session('_token')));
            }
        }
    }


    /**
     * 添加推送消息信息
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return zengjia($request);
        }
    }


    /**
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            return shanchu($request);
        }
    }
    /**
     * 获取推送消息列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
         return jiami_shousuo($request);
        }
    }

    /**
     *消息推送
     * @param Request $request
     * @return array
     */
    public function pushmsg(Request $request)
    {
        if ($request->isMethod('post')) {
            $user_id = $request->input('user_id');
            $msg_ids = $request->input('msg_ids');
            $shuju  = Msg::get();
            foreach ($shuju as $k =>$v){
                $msg_id =  $v->msg_id;
                $user_ids = UserMsg::select('user_id')->where('msg_id',$msg_id)->get()->toArray();
                $shuju[$k]['user_ids'] = $user_ids;
            }
            if ($shuju) {
                return encrypt_pass(serialize(['status' => 200 ,'data'=>$shuju]), cut_token(session('_token')));
            } else {
                return encrypt_pass(serialize(['status' => 500, 'errorinfo' => '暂无数据']), cut_token(session('_token')));
            }
        }
    }

}
