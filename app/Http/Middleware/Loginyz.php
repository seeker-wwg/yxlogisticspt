<?php

namespace App\Http\Middleware;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Manager;
use App\Http\Models\User;
use App\Http\Models\Driver;
use App\Http\Models\Permission;
use Closure;

class Loginyz
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
        $role = $request->input('role');
        if($role == 'user'){
            $user_id = $request->input('phone');
            $mg_id = User::select('operation')->where('phone', $user_id)->limit(1)->get()->toArray();
        }
        if($role == 'driver'){
            $user_id = $request->input('phone');
            $mg_id = Driver::select('operation')->where('phone', $user_id)->limit(1)->get()->toArray();
        }
        if($role == 'mg'){
            $user_id = $request->input('phone');
            $mg_id = Manager::select('operation')->where('phone', $user_id)->limit(1)->get()->toArray();
        }

        $operation =  $mg_id[0]['operation'];
        if($operation == '冻结'){
            exit (json_encode(['status'=>'505','operation'=>$operation]));
        }

        return $next($request);
    }
}
