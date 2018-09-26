<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Models\OperationLog;
use App\Http\Models\Permission;
use App\Http\Models\Driver;
use App\Http\Models\User;
use App\Http\Models\Manager;
class AdminOperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('user_id')){
            $user_id = $request->input('user_id');
            $mg_id = User::select('user_id','user_name')->where('user_id', $user_id)->limit(1)->get()->toArray();
            $user_id =  $mg_id[0]['user_id'];
            $identity =  '用户';
            $user_name =  $mg_id[0]['user_name'];
        }
        if($request->has('driver_id')){
            $user_id = $request->input('driver_id');
            $mg_id = Driver::select('driver_id','driver_name')->where('driver_id', $user_id)->limit(1)->get()->toArray();
            $user_id =  $mg_id[0]['driver_id'];
            $identity =  '司机';
            $user_name =  $mg_id[0]['driver_name'];
        }
        if($request->has('mg_id')){
            $user_id = $request->input('mg_id');
            $mg_id = Manager::select('mg_id','mg_name')->where('mg_id', $user_id)->limit(1)->get()->toArray();
            $user_id =  $mg_id[0]['mg_id'];
            $identity =  '管理员';
            $user_name =  $mg_id[0]['mg_name'];
        }
        //允许记录日志的接口
        $allow_url = [
            'admin/manager/login',
            'admin/wechat/cart_reserve_jiesuan',
            'admin/order/update_process',
        ];
        if('GET' != $request->method()){
//            $input = $request->all();
            $path = $request->path();

            if(in_array($path,$allow_url)){
            $path_name = Permission::select('ps_name')->where('ps_route','like',"%$path%")->limit(1)->get();
                if(!empty($path_name)){

                    $path_name = $path_name[0]->pa_name;
                }else{
                    $path_name = '操作成功';
                }
                if($path == 'admin/order/update_process'){
                    $path_name = '订单更改成功';
                }
            $log = new OperationLog(); # 提前创建表、model
            $log->uid = $user_id;
            $log->identity = $identity;
            $log->name = $user_name;
            $log->path_name = $path_name;
            $log->path = $path;
            $log->ip = $request->ip();
//            $log->input = json_encode($input, JSON_UNESCAPED_UNICODE);
            $log->save();
            }
        }
        return $next($request);
    }
}
