<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Models\OperationLog;
use App\Http\Models\Permission;
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
            $identity =  'user_id';
            $user_name =  $mg_id[0]['user_name'];
        }
        if($request->has('driver_id')){
            $user_id = $request->input('driver_id');
            $mg_id = Driver::select('driver_id','driver_name')->where('driver_id', $user_id)->limit(1)->get()->toArray();
            $user_id =  $mg_id[0]['driver_id'];
            $identity =  'driver_id';
            $user_name =  $mg_id[0]['driver_name'];
        }
        if($request->has('mg_id')){
            $user_id = $request->input('mg_id');
            $mg_id = Driver::select('mg_id','mg_name')->where('mg_id', $user_id)->limit(1)->get()->toArray();
            $user_id =  $mg_id[0]['mg_id'];
            $identity =  'mg_id';
            $user_name =  $mg_id[0]['mg_name'];
        }
        if('GET' != $request->method()){
//            $input = $request->all();
            $path = $request->path();
            $path_name = Permission::select('ps_name')->where('ps_route','like',"%$path%")->limit(1)->get();
            $path_name = $path_name[0]->pa_name;
            $log = new OperationLog(); # 提前创建表、model
            $log->uid = $user_id;
            $log->identity = $identity;
            $log->name = $user_name;
            $log->path_name = $path_name;
            $log->path = $path;
            $log->method = $request->method();
            $log->ip = $request->ip();
//            $log->input = json_encode($input, JSON_UNESCAPED_UNICODE);
            $log->save();   # 记录日志
        }
        return $next($request);
    }
}
