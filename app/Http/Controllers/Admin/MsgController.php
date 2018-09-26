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
    public function userid_index(Request $request)
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
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $user_id = $info['user_id'];
            $info = UserMsg::where('who', 'user')->where('who_id',$user_id)->get(['id']);
            $cnt  = count($info);
            $shuju =['count'=>$cnt];
            return re_jiami(500,$shuju,$token);
        }
    }
    /**
     * 将某一用户的推送消息置为“已读”状态
     * @param Request $request
     * @return array
     */
    public function status(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $user_id = $info['user_id'];
            $z = UserMsg::where('who', 'user')->where('who_id', $user_id)->update(['status' => '已读']);
            if ($z) {
                $shuju = ['errorinfo'=>'已更改成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'更改失败'];
                return re_jiami(500,$shuju,$token);
            }
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
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            foreach ($info['query'] as $k =>$v){
                $key  = $k;
                $value = $v;
            }
            $sjk = $info['sjk'];
            $ziyuan = orm_sjk($sjk);
            if( !is_object ($ziyuan)){
                return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
            }
            if(is_array($value)){
                $z = $ziyuan->whereIn($key,$value)->delete();
            }else{
                $z = $ziyuan->where($key,$value)->delete();
            }
            if ($z) {
                //前提$value是单个
                $zz = UserMsg::where($key,$value)->delete();
                $shuju = ['errorinfo'=>'删除成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'删除失败'];
                return re_jiami(500,$shuju,$token);
            }
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
     *消息推送(只推送给用户)
     * @param Request $request
     * @return array
     */
    public function pushmsg(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $formData = $info['formData'];
            $user_ids = $info['user_ids'];
            $z = Msg::Create($formData);
            if ($z) {
                $msg_id = $z->msg_id;
                foreach ($user_ids as $k =>$v){
                    $msg_user = [
                        'who_id' =>$v,
                        'who'=>'user',
                        'msg_id'=>$msg_id,
                        'status'=>'未读',
                    ];
                    UserMsg::create($msg_user);
                }
                $shuju = ['errorinfo'=>'推送消息成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'推送消息失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }

}
