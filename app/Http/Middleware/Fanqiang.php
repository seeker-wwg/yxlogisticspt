<?php

namespace App\Http\Middleware;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Manager;
use App\Http\Models\Permission;
use Closure;

class Fanqiang
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
        //当前请求路由
        $Cur_path = $request->path();
        //允许通过的接口
        $allow_url = ['admin/upload/upload_img','admin/wechat/cart_reserve_jiesuan'];
        if(!in_array($Cur_path,$allow_url)){
            if($request->has('mg_id')){
                $user_id = $request->input('mg_id');
                $mg_id = Manager::select('mg_id')->where('mg_id', $user_id)->limit(1)->get();
                $mg_id = $mg_id[0]->mg_id;
            }
            if (!empty($mg_id)){
                if($mg_id =1 ){

                    //(普通用户)翻墙访问限制
                    //① 获取用户的角色，根据角色 获取该用户可以访问的权限"控制器-操作方法"列表
                    $ps_ids = Manager::find($mg_id)->role->ps_ids;
                    $ps_id = Permission::select('ps_id')->where('ps_route','like',"%$Cur_path%")->limit(1)->get();
                    if(empty($ps_id[0])){
                        exit (json_encode(['status'=>'504']));
                    }else{
                        $ps_id = (string)$ps_id[0]->ps_id;
                    }
                    $ps_ids = explode(',',$ps_ids);
                    if(!in_array($ps_id,$ps_ids)){
    //                exit('没有权限访问！');
    //                return redirect('admin/err/index');
                        exit (json_encode(['status'=>'504','ps_id'=>$ps_id,'ps_ids'=>$ps_ids]));
                    }
                }
            }
        }
        return $next($request);
    }
}
