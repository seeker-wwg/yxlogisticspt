<?php

namespace App\Http\Middleware;
use App\Http\Models\User;
use App\Http\Models\Driver;
use App\Http\Models\Manager;
use Closure;

class Yanzheng
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
        //singn=md5(接口地址+userid+token+当前时间戳)的方式生成一个唯一标识sign，请求接口时
        $cur_path = $request->path();
        if($request->has('user_id')){
            $user_id = $request->input('user_id');
            $mg_id = User::select('token','token_time','operation')->where('user_id', $user_id)->limit(1)->get()->toArray();
            $token =  $mg_id[0]['token'];
        }
        if($request->has('driver_id')){
            $user_id = $request->input('driver_id');
            $mg_id = Driver::select('token','token_time','operation')->where('driver_id', $user_id)->limit(1)->get()->toArray();
            $token =  $mg_id[0]['token'];
        }
        if($request->has('mg_id')){
            $user_id = $request->input('mg_id');
            $mg_id = Manager::select('token','token_time','operation')->where('mg_id', $user_id)->limit(1)->get()->toArray();
            $token =  $mg_id[0]['token'];
        }
        $token_time =  $mg_id[0]['token_time'];
        $operation =  $mg_id[0]['operation'];
        if($operation == '冻结'){
            exit (json_encode(['status'=>'505','operation'=>$operation]));
        }
        $token_time=strtotime($token_time);
//            return $singn;
        $singn = $request->input('singn');
        $times = $request->input('times');
//        $times = strval($times);
//        $w_singn=$cur_path.$user_id.$token."$times";
        $h_singn = md5($cur_path.$user_id.$token."$times");
        if (time()-$times > 60){
//                dd (['status' => 502]);
//            exit (json_encode(['singn'=>$singn,'times' =>$times,'h_times'=>msectime(),'h_singn'=>$h_singn]));
                exit (json_encode(['status'=>'502']));
//                return '没有权限访问！';
            }

            if($token_time < $times ){
                exit (json_encode(['status'=>'501']));
            }
            if ($singn != $h_singn){
//                dd (['status' => 503]);
//                return ['status' => 503];
//                return '没有权限访问！';
//                exit (json_encode([
//                    'singn'=>$singn,
//                    'times' =>$times,
//                    'h_times'=>msectime(),
//                    'h_singn'=>$h_singn,
//                    '$w_singn'=>$w_singn,
//                    'token'=>$token,
//                    'url'=>$cur_path,
//                    'user_id'=>$user_id]
//                ));
                exit (json_encode(['status'=>'503','h_singn' => $h_singn,'singn'=>$singn,'token'=>$token]));
            }
        return $next($request);

    }
}
