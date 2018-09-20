<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/2
 * Time: 10:52
 */
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Models\Car;
use App\Http\Models\Driver;
use App\Http\Models\Manager;
use App\Http\Models\Order;
use App\Http\Models\Msg;
use App\Http\Models\VehType;
use App\Http\Models\OrderVeh;
use App\Http\Models\Uadd;
use App\Http\Models\Freight;
use App\Http\Models\Field;
use App\Http\Models\Banner;
use App\Http\Models\WBanner;
use App\Http\Models\Fit;
use App\Http\Models\Role;
use App\Http\Models\CarWai;
use App\Http\Models\Region;
use App\Http\Models\Permission;
use App\Http\Models\OperationLog;

function user_login(){

}

function xieru($data){
    if(is_array($data)){
        file_put_contents("data.txt",date('Y-m-d H:i:s', time()).' : '.json_encode($data).PHP_EOL,FILE_APPEND);
    }else{
        file_put_contents("data.txt",date('Y-m-d H:i:s', time()).' : '.$data.PHP_EOL,FILE_APPEND);
    }
}


//请求解密
function re_jiemi(Request $request){
    $data = $request->input('data');
    //应该需要判断
    if($request->has('user_id')){
        $user_id = $request->input('user_id');
        $mg_id = User::select('token')->where('user_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    if($request->has('driver_id')){
        $user_id = $request->input('driver_id');
        $mg_id = Driver::select('token')->where('driver_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    if($request->has('mg_id')){
        $user_id = $request->input('mg_id');
        $mg_id = Manager::select('token')->where('mg_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    $datainfo= decrypt_pass($data,$token);
    $datainfo=  json_decode($datainfo,true);

    return [$datainfo,$token];
}
//返回加密
function re_jiami($status,$info,$token,$res = null){
    $shuju =encrypt_pass(json_encode($info),$token);
    $info = ['status'=>$status,'fanhui'=>$res,'data'=>$shuju];
    return $info;
}

//返回未加密
function wei_jiami($status,$info,$res = null){
    $info =['status'=>$status,'fanhui'=>$res,'data'=>$info];
    return $info;
}
//判断变量是否设置  是否为空------------------------------------------
function cunzai($var){
    return isset($var) ? $var:null;
}

//返回数据库的对象------------------------------------------
function orm_sjk($sjk_name){
    switch ($sjk_name)
    {
        case 'user':
            $info = User::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
                });
            return $info;
        case 'car':
            $info = Car::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'order':
            $info = Order::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'fit':
            $info = Fit::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'msg':
            $info = Msg::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'veh_type':
            $info = VehType::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'order_veh':
            $info = OrderVeh::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'freight':
            $info = Freight::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'car_wai':
            $info = CarWai::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'field':
            $info = Field::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'banner':
            $info = Banner::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'wbanner':
            $info = WBanner::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'driver':
            $info = Driver::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'role':
            $info = Role::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'region':
            $info = Region::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'permission':
            $info = Permission::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'operation_log':
            $info =OperationLog::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        case 'uadd':
            $info = Uadd::where(function ($query){
                if(empty(1)){$query->where('order_sn', 'like', "%5acf0%");}
            });
            return $info;
            break;
        default:
           return 0;
//           return re_jiami('500',['errorinfo'=>'未找到查询数据库的字段'],$token) ;
    }
}
//请求解密 返回代号-------------------------------------------------------
function qingqiu_jiami(Request $request){
    $data = $request->input('data');
    //应该需要判断
    if($request->has('user_id')){
        $user_id = $request->input('user_id');
        $mg_id = User::select('token')->where('user_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    if($request->has('driver_id')){
        $user_id = $request->input('driver_id');
        $mg_id = Driver::select('token')->where('driver_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    if($request->has('mg_id')){
        $user_id = $request->input('mg_id');
        $mg_id = Manager::select('token')->where('mg_id', $user_id)->limit(1)->get()->toArray();
        $token =  $mg_id[0]['token'];
    }
    $datainfo= decrypt_pass($data,$token);
    $datainfo=  json_decode($datainfo,true);
        //获取前端的数据data与token
//    $token=$datainfo[1]; //这个是有点问题
    $info=$datainfo;

    //获取自定义字段
        $field = isset($info['field'])?$info['field']:null;
        $connect = isset($info['connect'])?$info['connect']:[];
        $population = isset($info['population'])?$info['population']:[];
        $sjk = isset($info['sjk'])?$info['sjk']:null;
        //B. 排序
        $offset = isset($info['start'])?$info['start']:null;
        $len = isset($info['length'])?$info['length']:null;
        $duan = isset($info['duan'])?$info['duan']:null;//获得排序的字段  --必须要传排序的字段
        $xu = isset($info['xu'])?$info['xu']:null;//获得排序的字段

        if(!isset($xu) || empty($xu)) {
            $xu = 'desc';
        }
    //检索字段
    $search = isset($info['search'])?$info['search']:[];  //----是个数组
    $jiansuo = isset($info['jiansuo'])?$info['jiansuo']:[];  //----是个数组
    $created_at = isset($info['created_at'])?$info['created_at']:null;
    $updated_at = isset($info['updated_at'])?$info['updated_at']:null;
    /**
     * $field--0 自定义获取的字段
     * $connect-->1   外键字段
     * $population -->2  自定义获取外键字段
     * $sjk-->3     '查询的数据库字段'
     * $offset-->4   '开始分页的字段'
     * $len-->5     '每页分页的字段'
     * $duan-->6    '排序的字段'
     * $xu-->7         'desc  asc'
     * $search-->8      '模糊搜索的字段'
     * $jiansuo -->9          '检索数据数组'[]
     * $created_at -->10  '时间搜索'
     * $updated_at --->11 '更新时间'
     * $token -->12   token
     * $info -->13   返回请求的数据
     */
    return [$field,$connect,$population,$sjk,$offset,
        $len,$duan,$xu,$search,$jiansuo,$created_at,$updated_at,$token,$info];
}

//请求解密 返回代号-------------------------------------------------------
function qingqiu_weijiami(Request $request){
    $info = $request->input('data');
    //获取自定义字段
    $field = isset($info['field'])?$info['field']:null;
    $connect = isset($info['connect'])?$info['connect']:[];
    $population = isset($info['population'])?$info['population']:[];
    $sjk = isset($info['sjk'])?$info['sjk']:null;
    //B. 排序
    $offset = isset($info['start'])?$info['start']:null;
    $len = isset($info['length'])?$info['length']:null;
    $duan = isset($info['duan'])?$info['duan']:null;//获得排序的字段  --必须要传排序的字段
    $xu = isset($info['xu'])?$info['xu']:null;//获得排序的字段

    if(!isset($xu) || empty($xu)) {
        $xu = 'desc';
    }
    //检索字段
    $search = isset($info['search'])?$info['search']:[];  //----是个数组
    $jiansuo = isset($info['jiansuo'])?$info['jiansuo']:[];  //----是个数组
    $created_at = isset($info['created_at'])?$info['created_at']:null;
    $updated_at = isset($info['updated_at'])?$info['updated_at']:null;
    /**
     * $field--0 自定义获取的字段
     * $connect-->1   外键字段
     * $population -->2  自定义获取外键字段
     * $sjk-->3     '查询的数据库字段'
     * $offset-->4   '开始分页的字段'
     * $len-->5     '每页分页的字段'
     * $duan-->6    '排序的字段'
     * $xu-->7         'desc  asc'
     * $search-->8      '模糊搜索的字段[]'
     * $jiansuo -->9          '检索数据数组'jiansuo:{'start':1,'type_id':{}}
     * $created_at -->10  '时间搜索'
     * $updated_at --->11 '更新时间'
     * $info -->12   返回请求的数据
     */
    return [$field,$connect,$population,$sjk,$offset,
        $len,$duan,$xu,$search,$jiansuo,$created_at,$updated_at,$info];
}
//----------------------------------------
/**
 *未加密的搜索
 * @param Request $request
 * @return array
 */
function shousuo(Request $request){

    $datainfo= qingqiu_weijiami($request);
//    xieru($datainfo);
    $shujk = orm_sjk($datainfo[3]);
    if( !is_object ($shujk)){
           return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    $search = $datainfo[8];
    $jiansuo = $datainfo[9];
    $created_at = $datainfo[10];
    $updated_at = $datainfo[11];

//    xieru($datainfo[5]);
    if(!is_null($datainfo[4]) && !empty($datainfo[5])){
        $shuju = $shujk->offset($datainfo[4])
            ->limit($datainfo[5])
            ->orderBy($datainfo[6], $datainfo[7])
            ->with($datainfo[1])
            //$jiansuo -->9          '检索数据数组'jiansuo:{'start':1,'type_id':{1,2,3}}
            ->where(function($query) use($request,$jiansuo){
                foreach ($jiansuo as $k => $v){
                    if ($v == '0' || (!empty($v)   && ($v != 'unde') && ($v != 'de'))){
                        //新修改1 加上数组检索
                        if(is_array($v)){
                            $query->whereIn($k,$v);
                        }else{
                            $query->where($k, $v);
                        }
                    }else if($v == 'unde'){
//                        $v = null;
                        $query->where($k, null);
                    }else if($v == 'de'){
                        $query->where($k, '!=',null);
                    }
//                    if($k = 'created_at'){
//                        if ( !empty($v)){
//                            $query->whereBetween('created_at',$v);
//                        }
//                    }
//                    if($k = 'updated_at'){
//                        if ( !empty($v)){
//                            $query->whereBetween('updated_at',$v);
//                        }
//                    }
                }
            })
            //$search-->8      '模糊搜索的字段[]'['name'=>'王','phone'=>'158']
            ->where(function($query) use($request,$search){
                foreach ($search as $k => $v){
                    if ($v == '0' || !empty($v) ){
                        $query->where($k,'like',"%$v%");
                    }
                }
            })
            //$created_at -->10  '时间搜索'
            ->where(function ($query) use($request,$created_at){
                if ( !empty($created_at)){
                    $query->whereBetween('created_at',$created_at);
                }
            })
            //$updated_at -->11  '时间搜索'
            ->where(function ($query) use($request,$updated_at){
                if ( !empty($updated_at)){
                    $query->whereBetween('updated_at',$updated_at);
                }
            })
            ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
    }else{
        $shuju =$shujk->orderBy($datainfo[6], $datainfo[7])
            ->with($datainfo[1])
            ->where(function($query) use($request,$jiansuo){
                foreach ($jiansuo as $k => $v){
                    if ($v == '0' || (!empty($v)   && ($v != 'unde') && ($v != 'de'))){
                        //新修改1 加上数组检索
                        if(is_array($v)){
                            $query->whereIn($k,$v);
                        }else{
                            $query->where($k, $v);
                        }
                    }else if($v == 'unde'){
//                        $v = null;
                        $query->where($k, null);
                    }else if($v == 'de'){
                        $query->where($k, '!=',null);
                    }
                }
            })
            ->where(function($query) use($request,$search){
                foreach ($search as $k => $v){
                    if ($v == '0' || !empty($v) ){
                        $query->where($k,'like',"%$v%");
                    }
                }
            })
            ->where(function ($query) use($request,$created_at){
                if ( !empty($created_at)){
                    $query->whereBetween('created_at',$created_at);
                }
            })
            //$updated_at -->11  '时间搜索'
            ->where(function ($query) use($request,$updated_at){
                if ( !empty($updated_at)){
                    $query->whereBetween('updated_at',$updated_at);
                }
            })
            ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
    }
    //添加额外的字段

    foreach ($shuju as $k=>$v){
        foreach ($datainfo[1] as $kk => $vv){
            if(isset($v->$vv) && !empty($v->$vv)){
                $userinfo=$v->$vv->toArray();
                unset($shuju[$k][$vv]);
                $d = test_odd($userinfo,$datainfo[2]);
                $shuju[$k][$vv] = $d;
            }
        }
    }
    return wei_jiami(200,$shuju,$datainfo[12]);
}


//-----------------------------------------------------
/**
 * 加密的搜索
 * @param Request $request
 * @return array
 */
function jiami_shousuo(Request $request){

    $datainfo= qingqiu_jiami($request);
    $shujk = orm_sjk($datainfo[3]);
    if( !is_object ($shujk)){
        return  re_jiami(500,['errorinfo'=>'未找到查询数据库的字段'],$datainfo[12]);
    }
    $search = $datainfo[8];
    $jiansuo = $datainfo[9];
    xieru($jiansuo);
    $created_at = $datainfo[10];
    $updated_at = $datainfo[11];
//return [$datainfo[4],$datainfo[5]];
    if(!is_null($datainfo[4]) && !empty($datainfo[5])){
        $shuju = $shujk->offset($datainfo[4])
            ->limit($datainfo[5])
            ->orderBy($datainfo[6], $datainfo[7])
            ->with($datainfo[1])
            ->where(function($query) use($request,$jiansuo){
                foreach ($jiansuo as $k => $v){
                    if ($v == '0' || (!empty($v)   && ($v != 'unde') && ($v != 'de'))){
                        //新修改1 加上数组检索
                        if(is_array($v)){
                            $query->whereIn($k,$v);
                        }else{
                            $query->where($k, $v);
                        }
                    }else if($v == 'unde'){
//                        $v = null;
                        $query->where($k, null);
                    }else if($v == 'de'){
                        $query->where($k, '!=',null);
                    }
                }
            })
            //            $search-->8      '模糊搜索的字段[]'['name'=>'王','phone'=>'158']
            ->where(function($query) use($request,$search){
                foreach ($search as $k => $v){
                    if ($v == '0' || !empty($v) ){
                        $query->where($k,'like',"%$v%");
                    }
                }
            })
            ->where(function ($query) use($request,$created_at){
                if ( !empty($created_at)){
                    $query->whereBetween('created_at',$created_at);
                }
            })

            //$updated_at -->11  '时间搜索'
            ->where(function ($query) use($request,$updated_at){
                if ( !empty($updated_at)){
                    $query->whereBetween('updated_at',$updated_at);
                }
            })
            ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
    }else{
        $shuju =$shujk->orderBy($datainfo[6], $datainfo[7])
            ->with($datainfo[1])
            ->where(function($query) use($request,$jiansuo){
                foreach ($jiansuo as $k => $v){
                    if ($v == '0' || (!empty($v)   && ($v != 'unde') && ($v != 'de'))){
                        //新修改1 加上数组检索
                        if(is_array($v)){
                            $query->whereIn($k,$v);
                        }else{
                            $query->where($k, $v);
                        }
                    }else if($v == 'unde'){
//                        $v = null;
                        $query->where($k, null);
                    }else if($v == 'de'){
                        $query->where($k, '!=',null);
                    }
                }
            })
            //$search-->8      '模糊搜索的字段[]'['name'=>'王','phone'=>'158']
            ->where(function($query) use($request,$search){
                foreach ($search as $k => $v){
                    if ($v == '0' || !empty($v) ){
                        $query->where($k,'like',"%$v%");
                    }
                }
            })
            ->where(function ($query) use($request,$created_at){
                if ( !empty($created_at)){
                    $query->whereBetween('created_at',$created_at);
                }
            })
            //$updated_at -->11  '时间搜索'
            ->where(function ($query) use($request,$updated_at){
                if ( !empty($updated_at)){
                    $query->whereBetween('updated_at',$updated_at);
                }
            })
            ->get($datainfo[0]); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
    }
    //添加额外的字段

    foreach ($shuju as $k=>$v){
        foreach ($datainfo[1] as $kk => $vv){
            if(isset($v->$vv) && !empty($v->$vv)){
                $userinfo=$v->$vv->toArray();
                unset($shuju[$k][$vv]);
                $d = test_odd($userinfo,$datainfo[2]);
                $shuju[$k][$vv] = $d;
            }
        }
    }

    return re_jiami(200,$shuju,$datainfo[12],$datainfo[13]);
}
//-----------------------------------------------------
/**
 * 用来验证手机号是否已注册的 函数
 * $zdy_kv  一些值要自定义的
 * @param Request $request
 * @return array|string
 * 要传入  data{formData:{数组},sjk:'dd'}
 */
function phone_yz($phone,$role){
    if($role = 'user_id'){
        $mg_id = User::select('phone')->where('phone', $phone)->limit(1)->get()->toArray();
    }
    if($role = 'driver_id'){
        $mg_id = Driver::select('phone')->where('phone', $phone)->limit(1)->get()->toArray();
    }
    if($role = 'mg_id'){
        $mg_id = Manager::select('phone')->where('phone', $phone)->limit(1)->get()->toArray();
    }
    if(!empty($mg_id[0])){
        return true;
    }
}
//*****************************************************************************************
function Only_yz($sjk)
{
    switch ($sjk) {
        case 'region':
            $info = ['region_name'=>'你添加区域名称已存在'];
            return $info;
            break;
        case 'order':
            $info = ['region_name'];
            return $info;
            break;
        case 'fit':
            $info = ['region_name'];
            return $info;
            break;
        case 'msg':
            $info = ['region_name'];
            return $info;
            break;
        case 'veh_type':
            $info = ['region_name'];
            return $info;
            break;
        case 'order_veh':
            $info = ['region_name'];
            return $info;
            break;
        case 'freight':
            $info = ['region_name'];
            return $info;
            break;
        case 'field':
            $info = ['region_name'];
            return $info;
            break;
        case 'banner':
            $info = ['region_name'];
            return $info;
            break;
        case 'wbanner':
            $info = ['region_name'];
            return $info;
            break;
        case 'driver':
            $info = ['region_name'];
            return $info;
            break;
        case 'role':
            $info = ['region_name'];
            return $info;
            break;
        case 'permission':
            $info = ['region_name'];
            return $info;
            break;
        case 'operation_log':
            $info = ['region_name'];
            return $info;
            break;
        case 'uadd':
            $info = Uadd::where(function ($query) {
                if (empty(1)) {
                    $query->where('order_sn', 'like', "%5acf0%");
                }
            });
            return $info;
            break;
        default:
            return 0;
    }
}
//***************************************************************************************
/**
 * 增加数据库  加密的
 * $zdy_kv  一些值要自定义的
 * @param Request $request
 * @return array|string
 * 要传入  data{formData:{数组},sjk:'dd'}
 */
function zengjia(Request $request,$zdy_kv =[]){
    $datainfo =re_jiemi($request);
    $info = $datainfo[0];
    $token = $datainfo[1];
    $sjk = $info['sjk'];
    $ziyuan = orm_sjk($sjk);
    $formData = $info['formData'];

    if(array_key_exists('password', $formData)){
        $formData['password'] = bcrypt($formData['password']);
    }
    if(!empty($zdy_kv)){
        foreach ($zdy_kv as $k => $v){
            $formData[$k] = $v;
        }
    }
    if( !is_object ($ziyuan)){
        return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    $z = $ziyuan->create($formData);
    if ($z) {
        $shuju = ['errorinfo'=>'增加成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'增加失败'];
        return re_jiami(500,$shuju,$token);
    }
}


/**
 * 增加数据库  加密的
 * $zdy_kv  一些值要自定义的
 * @param Request $request
 * @return array|string
 * 要传入  data{formData:{数组},sjk:'dd'}
 */
function zengjia_yz(Request $request,$zdy_kv =[]){
    $datainfo =re_jiemi($request);
    $info = $datainfo[0];
    $token = $datainfo[1];
    $sjk = $info['sjk'];
    $ziyuan = orm_sjk($sjk);
    $formData = $info['formData'];
    $yz_ziduan =  only_yz($sjk);
    if(array_key_exists('password', $formData)){
        $formData['password'] = bcrypt($formData['password']);
    }
    if(!empty($zdy_kv)){
        foreach ($zdy_kv as $k => $v){
            $formData[$k] = $v;
        }
    }
    if( !is_object ($ziyuan)){
        return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    if($yz_ziduan){
        foreach ($yz_ziduan as $k => $v){
            if(isset($formData[$k]) && !empty($formData[$k])){
                $cunzai_ziduan = $ziyuan->select($k)->where($k,$formData[$k])->get();
                if(count($cunzai_ziduan) !== 0){
                    $shuju = ['errorinfo'=> $v];
                    return re_jiami(500,$shuju,$token);
                }
            }
        }
    }
    $z = $ziyuan->create($formData);
    if ($z) {
        $shuju = ['errorinfo'=>'增加成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'增加失败'];
        return re_jiami(500,$shuju,$token);
    }
}

/**
 * 增加多个数据库  加密的
 * $zdy_kv  一些值要自定义的
 * @param Request $request
 * @return array|string
 * 要传入  data{formData:{数组},sjk:'dd'}
 */
function zengjia_duo(Request $request){
        $datainfo =re_jiemi($request);
    $info = $datainfo[0];
    $token = $datainfo[1];
    $sjk = $info['sjk'];
    $ziyuan = orm_sjk($sjk);
    if( !is_object ($ziyuan)){
        return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    $formData = $info['formData'];
    foreach ($formData as $k => $v){
        $z = $ziyuan->create($v);
    }
    if ($z) {
        $shuju = ['errorinfo'=>'增加成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'增加失败'];
        return re_jiami(500,$shuju,$token);
    }
}
//-----------------------------------------------------
/**
 * 自定义逻辑增加数据库  加密的
 * @param Request $request
 * @return array|string
 * 要传入  data{formData:{数组},sjk:'dd'}
 */
function luoji_zengjia($sjk,$formData,$token){
    $ziyuan = orm_sjk($sjk);
    if( !is_object ($ziyuan)){
        return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    $z = $ziyuan->create($formData);
    if ($z) {
        $shuju = ['errorinfo'=>'增加成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'增加失败'];
        return re_jiami(500,$shuju,$token);
    }
}



//-----------------------------------------------------
/**
 * 修改数据库  加密的
 * @param Request $request
 * @return array|string
 * 注意  传入的值data 的  只能传入一个条件 query :{'字段':'值'} formData sjk
 * data:{formData:{},sjk:"",query :{'字段':'值'}}
 */
function xiugai(Request $request){
    $datainfo =re_jiemi($request);
    $info = $datainfo[0];
    $token = $datainfo[1];
    $formData = $info['formData'];
    if(array_key_exists('password', $formData)){
        $formData['password'] = bcrypt($formData['password']);
    }
    $query = $info['query'];
    foreach ($query as $k =>$v){
        $key  = $k;
        $value = $v;
    }

    $sjk = $info['sjk'];
    $ziyuan = orm_sjk($sjk);
    if( !is_object ($ziyuan)){
        return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
    }
    $z = $ziyuan->where($key,$value)->update($formData);;
    if ($z) {
        $shuju = ['errorinfo'=>'修改成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'修改失败'];
        return re_jiami(500,$shuju,$token);
    }
}



/**
 * 修改数据库  加密的
 * @param Request $request
 * @return array|string data:{'sjk':'','query':{'id','1,2,3'}}
 *
 */
function shanchu(Request $request){
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
        $shuju = ['errorinfo'=>'删除成功'];
        return re_jiami(200,$shuju,$token);
    } else {
        $shuju = ['errorinfo'=>'删除失败'];
        return re_jiami(500,$shuju,$token);
    }
}



//数组过滤
function test_odd($a,$c){
    $keys =  array_keys($a);
    foreach ($keys as $k => $v){
        if(!in_array($v,$c)){
            unset($a[$v]);
        }
    }
    return $a;
}


function cut_token($token){
    return substr($token,0,32);
}

//CURL分别以GET、POST方式请求HTTPS协议接口api
function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}


/* PHP CURL HTTPS POST */
function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errorinfono($curl)) {
        echo 'Errno'.curl_errorinfoor($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据，json格式
}
    function jiama($input,$key){
        if(is_array($input)){
            $data = null;
            foreach ($input as $k => $v){
                if(is_array($v)){
                    //如果$v还是数组   进行递归
                    jiama($v,$key);
                }else{
                    $data[$k] = encrypt_pass($v,$key);
                }
            }
            return $data;
        }else{
            encrypt_pass($input, $key);
        }
    }

    // AES加密
     function encrypt_pass($input, $key) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $input = pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv = '01Gx03Yx05WW0607';
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }


    //填充
     function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }


    //解密
      function decrypt_pass($sStr, $sKey) {
        $iv = '01Gx03Yx05WW0607';
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_CBC,
            $iv
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
//-----------------------------------------------------
function apiDataDecrypt($data, $key='') {
    $data = base64_decode($data);
    $pad = 16 - (strlen($data) % 16);
    $padData = $data . str_repeat(chr($pad), $pad);
    return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$padData, MCRYPT_MODE_ECB);
}

function decryptString($str,$key) {
    $str = base64_decode($str);
    $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
    $block = mcrypt_get_block_size('rijndael_128', 'ecb');
    $pad = ord($str[($len = strlen($str)) - 1]);
    $len = strlen($str);
    $pad = ord($str[$len-1]);
    return substr($str, 0, strlen($str) - $pad);
}
//------------------------------------------------------------

function getRouthList(){
    $app = app();
    $routes = $app->routes->getRoutes();
    foreach ($routes as $k=>$value){
        $path[$k]['uri'] = $value->uri;

//        $path[$k]['path'] = $value->methods[0];

    }
    return $path;
}


/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}

/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}


/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,DIRECTORY_SEPARATOR),1));

    return ['controller' => $class, 'method' => $method];
}

/***********递归方式获取上下级权限信息****************/
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['ps_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['ps_pid']])){
            $items[$item['ps_pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}
/***********递归方式获取上下级权限信息****************/
//PHP通过正则表达式提取字符串中的手机号并判断运营商，简单快速方便，能提取多个手机号。
function findThePhoneNumbers($oldStr = ""){

    // 检测字符串是否为空
    $oldStr=trim($oldStr);
    $numbers = array();
    if(empty($oldStr)){
        return $numbers;
    }

    // 删除86-180640741122，0997-8611222之类的号码中间的减号（-）
    $strArr = explode("-", $oldStr);
    $newStr = $strArr[0];
    for ($i=1; $i < count($strArr); $i++) {
        if (preg_match("/\d{2}$/", $newStr) && preg_match("/^\d{11}/", $strArr[$i])){
            $newStr .= $strArr[$i];
        } elseif (preg_match("/\d{3,4}$/", $newStr) && preg_match("/^\d{7,8}/", $strArr[$i])) {
            $newStr .= $strArr[$i];
        } else {
            $newStr .= "-".$strArr[$i];
        }
    }

    // 手机号的获取
    $reg='/\D(?:86)?(\d{11})\D/is';//匹配数字的正则表达式
    preg_match_all($reg,$newStr,$result);
    $nums = array();
    // * 中国移动：China Mobile
    // * 134[0-8],135,136,137,138,139,150,151,157,158,159,182,187,188
    $cm = "/^1(34[0-8]|(3[5-9]|5[017-9]|8[278])\d)\d{7}$/";
    // * 中国联通：China Unicom
    // * 130,131,132,152,155,156,185,186
    $cu = "/^1(3[0-2]|5[256]|8[56])\d{8}$/";
    // * 中国电信：China Telecom
    // * 133,1349,153,180,189
    $ct = "/^1((33|53|8[09])[0-9]|349)\d{7}$/";
    //
    foreach ($result[1] as $key => $value) {
        if(preg_match($cm,$value)){
            $nums[] = array("number" => $value, "type" => "中国移动");
        }elseif(preg_match($cu,$value)){
            $nums[] = array("number" => $value, "type" => "中国联通");
        }elseif(preg_match($ct,$value)){
            $nums[] = array("number" => $value, "type" => "中国电信");
        }else{
            // 非法号码
        }
    }
    $numbers["mobile"] = $nums;


    // 固定电话或小灵通的获取
    $reg='/\D(0\d{10,12})\D/is';//匹配数字的正则表达式
    preg_match_all($reg,$newStr,$result);
    $nums = array();
    // * 大陆地区固定电话或小灵通
    // * 区号：010,020,021,022,023,024,025,027,028,029
    // * 号码：七位或八位
    $phs = "/^0(10|2[0-5789]|\d{3})\d{7,8}$/";
    foreach ($result[1] as $key => $value) {
        if(preg_match($phs, $value)){
            $nums[] = array("number" => $value, "type" => "固定电话或小灵通");
        } else {
            // 非法
        }
    }
    $numbers["landline"] = $nums;


    // 有可能是没有区号的固定电话的获取
    $reg='/\D(\d{7,8})\D/is';//匹配数字的正则表达式
    preg_match_all($reg,$newStr,$result);
    $nums = array();
    foreach ($result[1] as $key => $value) {
        $nums[] = array("number" => $value, "type" => "没有区号的固定电话");
    }
    $numbers["possible"] = $nums;

    // 返回最终数组
    return $numbers;
}


/**
 * Sort multi array by filed and type.
 * 多字段排序
 * @param data $array
 * @param condition $array
 */
 function sortMultiArray($data, $condition)
{
    if (count($data) <= 0 || empty($condition)) {
        return $data;
    }
    $dimension = count($condition);
    $fileds = array_keys($condition);
    $types = array_values($condition);
    switch ($dimension) {
        case 1:
            $data = sort1Dimension($data, $fileds[0], $types[0]);
            break;
        case 2:
            $data =sort2Dimension($data, $fileds[0], $types[0], $fileds[1], $types[1]);
            break;
        default:
            $data = sort3Dimension($data, $fileds[0], $types[0], $fileds[1], $types[1], $fileds[2], $types[2]);
            break;
    }
    return $data;
}
 function sort1Dimension(&$data, $filed, $type)
{
    if (count($data) <= 0) {
        return $data;
    }
    foreach ($data as $key => $value) {
        $temp[$key] = $value[$filed];
    }
    array_multisort($temp, $type, $data);
    return $data;
}

function sort2Dimension(&$data, $filed1, $type1, $filed2, $type2)
{
    if (count($data) <= 0) {
        return $data;
    }
    foreach ($data as $key => $value) {
        $sort_filed1[$key] = $value[$filed1];
        $sort_filed2[$key] = $value[$filed2];
    }
    array_multisort($sort_filed1, $type1, $sort_filed2, $type2, $data);
    return $data;
}

 function sort3Dimension(&$data, $filed1, $type1, $filed2, $type2, $filed3, $type3)
{
    if (count($data) <= 0) {
        return $data;
    }
    foreach ($data as $key => $value) {
        $sort_filed1[$key] = $value[$filed1];
        $sort_filed2[$key] = $value[$filed2];
        $sort_filed3[$key] = $value[$filed3];
    }
    array_multisort($sort_filed1, $type1, $sort_filed2, $type2, $sort_filed3, $type3, $data);
    return $data;
}

/**
 * 排3维数组的3维字段
 * @param $data
 * @param $e_ziduan
 * @param $s_ziduan
 * @return mixed
 */
function mul_sort($data,$e_ziduan,$s_ziduan){
//    array_multisort(array_column(array_column($data, $e_ziduan), $s_ziduan), SORT_DESC, $data);
    array_multisort(array_column(array_column($data, $e_ziduan), $s_ziduan), SORT_ASC, $data);
    return $data;
}


