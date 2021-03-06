<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Order;
use App\Http\models\OrderComment;
use App\Http\models\Msg;
use App\Http\models\UserMsg;
use App\Http\models\OrderVeh;
use App\Http\models\OrderCar;
use App\Http\models\OrderWai;
use App\Http\models\Vehicle;
use App\Http\Models\Manager;
use App\Http\Models\Freight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Models\User;
use App\Http\Models\Car;
use App\Http\Models\CarWai;
use App\Http\Models\Region;
use App\Tools\Cart;
class OrderController extends Controller
{
 
    /**
     * 订单查询
     * @param Request $request
     */
    public function index(Request $request)
    {


        if ($request->isMethod("post")) {
//            //A. 数据分页(显示条数)
//
//            $info_1 = re_jiemi($request);
//            $datainfo=$info_1[0];
//            $offset = $datainfo['start'];
//            $len = $datainfo['length'];
//            $field = $datainfo['field'];
//            $connect = $datainfo['connect'];
//            $population = $datainfo['population'];
//
////            return $field;
//
//
//            //获取字段信息
//            $user_id = isset($datainfo['user_id'])?$datainfo['user_id']:null;
//            $order_sn = isset($datainfo['order_sn'])?$datainfo['order_sn']:null;
//                $process = isset($datainfo['process'])?$datainfo['process']:null;
//                $pay_status = isset($datainfo['pay_status'])?$datainfo['pay_status']:null;
//                $search_time =isset($datainfo['created_at'])?$datainfo['created_at']:null;
////            return [$offset,$len,$process];
////                dd($search_time[0]);
//            //B. 排序(如果为空则 order_id  倒序)
//            $duan = isset($datainfo['duan'])?$datainfo['duan']:null;//获得排序的字段
//          if (empty($duan)){
//              $duan = 'order_id';
////              $xu = $request->input('desc');  //排序的顺序asc/desc
//              $xu = 'desc';
//          }else{
//              $xu = 'desc';
//          }
//            if (!is_null($offset) && !empty($len)){
//                $shuju = Order::offset($offset)
//                    ->limit($len)
//
//                    ->with($connect)
//                    ->orderBy($duan, $xu)
//                    ->where(function ($query) use($request,$order_sn){
//                        if (!empty($order_sn)){
//                            $query->where('order_sn', 'like', "%$order_sn%");
//                        }
//                    })
//                    ->where(function ($query) use($request,$user_id){
//                        if (!empty($user_id)){
//                            $query->where('user_id', $user_id);
//                        }
//                    })
//                    ->where(function ($query) use($request,$order_sn,$process,$pay_status,$search_time){
//                        if (!empty($process) && !empty($pay_status) && !empty($search_time)){
//                            $query->where('process', $process)
//                                ->where('pay_status', $pay_status)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && !empty($pay_status)){
//                            $query->where('process', $process)
//                                ->where('pay_status', $pay_status);
//                        }elseif (!empty($pay_status) && !empty($search_time)){
//                            $query->where('pay_status', $pay_status)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && !empty($search_time)){
//                            $query->where('process', $process)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && empty($pay_status) && empty($search_time)){
//                            $query->where('process', $process);
//                        }elseif (empty($process) && !empty($pay_status) && empty($search_time)){
//                            $query->where('pay_status', $pay_status);
//                        }elseif (empty($process) && empty($pay_status) && !empty($search_time)){
//                            $query->whereBetween('created_at',$search_time);
//                        }
//                    })
//                    ->get($field); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
//            }else{
//                $shuju = Order::
//                    with($connect)
//                    ->orderBy($duan, $xu)
//                    ->where(function ($query) use($request,$order_sn){
//                        if (!empty($order_sn)){
//                            $query->where('order_sn', 'like', "%$order_sn%");
//                        }
//                    })
//                    ->where(function ($query) use($request,$order_sn,$process,$pay_status,$search_time){
//                        if (!empty($process) && !empty($pay_status) && !empty($search_time)){
//                            $query->where('process', $process)
//                                ->where('pay_status', $pay_status)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && !empty($pay_status)){
//                            $query->where('process', $process)
//                                ->where('pay_status', $pay_status);
//                        }elseif (!empty($pay_status) && !empty($search_time)){
//                            $query->where('pay_status', $pay_status)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && !empty($search_time)){
//                            $query->where('process', $process)
//                                ->whereBetween('created_at',$search_time);
//                        }elseif (!empty($process) && empty($pay_status) && empty($search_time)){
//                            $query->where('process', $process);
//                        }elseif (empty($process) && !empty($pay_status) && empty($search_time)){
//                            $query->where('pay_status', $pay_status);
//                        }elseif (empty($process) && empty($pay_status) && !empty($search_time)){
//                            $query->whereBetween('created_at',$search_time);
//                        }
//                    })
//                    ->get($field); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
//            }
//
//                foreach ($shuju as $k=>$v){
//                    $order_veh = OrderVeh::select()->where('order_id',$v->order_id)->get();
////                   foreach ($order_veh as $k=>$v ){
////                       $veh_name[$k] = Vehicle::select('veh_name')->where('veh_id',$v->veh_id)->get();
////                   }
//
////                    return $shuju[$k]['user'];
//                    $shuju[$k]['order_veh'] = $order_veh;
//
//                    if(isset($v->user) && !empty($v->user)){
//                        $userinfo=$v->user->toArray();
//                        unset($shuju[$k]['user']);
//                        $d = test_odd($userinfo,$population);
//                        $shuju[$k]['userinfo'] = $d;
//                    }
//
//                    if(isset($v->driver) && !empty($v->driver)) {
//                        $driverinfo = $v->driver->toArray();
//                        unset($shuju[$k]['driver']);
//
//                        $c = test_odd($driverinfo, $population);
//                        $shuju[$k]['driverinfo'] = $c;
//                    }
//
//
//                    if(isset($v->order_wai) && !empty($v->order_wai)){
//                        $waiinfo = $v->order_wai;
//                        foreach ($waiinfo as $kk =>$vv ){
//                            if(isset($vv->mg_id) && !empty($vv->mg_id)){
//                                $mg_info = Manager::select('mg_id','mg_name')->find($vv->mg_id);
//                                $vv->mg_id = $mg_info;
//                            }
//                        }
//                    }
//
//
//                }
            return jiami_shousuo($request);
        }
    }

    /**
     * 添加订单
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];

            $formData = $info['formData'];
            $sjk = $info['sjk'];
            $car_data = $info['car_data'];
//            $freight_id = $info['freight_id'];
            //定金
            $order_sn = uniqid('');
           // 尾款
            $w_order_sn = uniqid('');
            //计算总价
            //1.车的费用
//            $car_cost = Freight::whereIn('freight_id',$freight_id)->get(['freight_cost')->toArray();
//            $car_costs = 0;
//                foreach ($car_cost as $kk => $vv) {
//                        $car_costs += $vv['freight_cost'];
//                }

//
//            //送车上门的费用
//            if($formData['sender_type'] == '平台派人上门取车'){
//                $sender_cost = Region::select('carry_out_cost')->find($info['sender_id']);
//                $sender_cost = $sender_cost->carry_out_cost;
//            }
//            if($formData['receive_type'] == '平台派人送车上门'){
//                $receive_cost = Region::select('carry_out_cost')->find($info['receive_id']);
//                $receive_cost = $receive_cost->carry_out_cost;
//            }
//            //总额
//            $total_price = $car_costs + $sender_cost + $receive_cost + $formData['baoe_cost'] + $formData['baofei_cost'];
//
//            if($formData['total_price'] !== $total_price){
//                $formData['total_price'] = $total_price;
//            }

            //2.上门取车
            $ziyuan = orm_sjk($sjk);
            if( !is_object ($ziyuan)){
                return  wei_jiami(500,['errorinfo'=>'未找到查询数据库的字段']);
            }
            $formData['order_sn'] = $order_sn;
            $formData['w_order_sn'] = $w_order_sn;
            $z = $ziyuan->create($formData);
            if ($z) {
                if(!empty($car_data)){
                    foreach ($car_data as $v) {
                        $v['order_id'] =$z->order_id;
                        OrderVeh::create($v);
                    }
                }
                $data_wai = ['order_id'=>$z->order_id,'status_updata'=>'审核中','status_updata_time'=>date('Y-m-d H:i:s', time())];
                OrderWai::create($data_wai);
                $shuju = ['errorinfo'=>'生成订单成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'生成订单失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
                return xiugai($request);
            }
    }

    public function update_process(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $formData = $info['formData'];
            $order_id = $info['order_id'];
            $z = Order::where('order_id',$order_id)->update($formData);
            if ($z) {
               $uo_msg = Order::where('order_id',$order_id)->get(['order_sn','user_id','process','not_pass']);
                if($formData['process'] == '待付款'){
                    //创建用户推荐消息
                    $user_msg  =[
                        'mg_id'=>0,
                        'title'=>'你有待付款的订单',
                        'content'=>'你有订单号为'.$uo_msg[0]->order_sn.',已审核通过请付款',
                        ];
                  $mz =  Msg::create($user_msg);
                  $ut_msg = [
                      'who'=>'user',
                      'who_id'=>$uo_msg[0]->user_id,
                      'msg_id'=>$mz->msg_id,
                      'status'=>'未读',
                  ];
                    $tz =  UserMsg::create($ut_msg);
                }
                if($formData['process'] == '已完成'){
                    //创建用户推荐消息
                    $user_msg  =[
                        'mg_id'=>0,
                        'title'=>'你有订单已完成收车',
                        'content'=>'你有订单号为'.$uo_msg[0]->order_sn.',已完成收车',
                    ];
                    $mz =  Msg::create($user_msg);
                    $ut_msg = [
                        'who'=>'user',
                        'who_id'=>$uo_msg[0]->user_id,
                        'msg_id'=>$mz->msg_id,
                        'status'=>'未读',
                    ];
                    $tz =  UserMsg::create($ut_msg);
                }
                if($uo_msg[0]->process == '已取消' && !empty($uo_msg[0]->not_pass)){
                    //创建用户推荐消息
                    $user_msg  =[
                        'mg_id'=>0,
                        'title'=>'你有订单审核未通过',
                        'content'=>'你有订单号为'.$uo_msg[0]->order_sn.',审核未通过,原因是:'.$uo_msg[0]->not_pass,
                    ];
                    $mz =  Msg::create($user_msg);
                    $ut_msg = [
                        'who'=>'user',
                        'who_id'=>$uo_msg[0]->user_id,
                        'msg_id'=>$mz->msg_id,
                        'status'=>'未读',
                    ];
                    $tz =  UserMsg::create($ut_msg);
                }
                $data_wai = ['order_id'=> $order_id,'status_updata'=>$formData['process'],'status_updata_time'=>date('Y-m-d H:i:s', time())];
                OrderWai::create($data_wai);
                $shuju = ['errorinfo'=>'订单状态修改成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'订单状态修改失败'];
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
        if ($request->isMethod('post')){
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
                $z_veh = OrderVeh::whereIn('order_id',$value)->delete();
            }else{
                $z = $ziyuan->where($key,$value)->delete();
                $z_veh = OrderVeh::where('order_id',$value)->delete();
            }
            if ($z) {
                $shuju = ['errorinfo'=>'删除成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'删除失败'];
                return re_jiami(500,$shuju,$token);
            }
        }

    }

    /**
     * 装车
     * @param Request $request
     * @return array
     */
    public function load_car(Request $request)
    {
        if ($request->isMethod('post')){
           $info = re_jiemi($request);
           $data = $info[0];
           $token  = $info[1];
            $huo_num = 0;
            $y_num = 0;
            $veh_ids = $data['veh_id'];
            $car_ids =$data['car_ids'];
            //状态码
            $ztm = [];
            if(count($veh_ids) != count($car_ids)){
                $shuju = ['errorinfo'=>'数量不匹配'];
                return re_jiami('500',$shuju,$token);
            }else{
                foreach ($car_ids as $k => $v){
                    $status = Car::select('state','yuxia_num')->where('car_id',$v)->limit(1)->get();
                   //获取这个货车被装之前的余量
                    $yuxia_num = $status[0]->yuxia_num;
                    //更新car 车位余量变量
                    $yuxia_num_0 = $yuxia_num;
                    if($status[0]->state === '运输中' || $status[0]->state === '停运'){
                        $ztm[$k] = 3;
                        continue;
                    }
                    $y_info = OrderVeh::with('veh_type')->whereIn('order_veh_id',$veh_ids[$k])->get(['type_id'])->toArray();
                    foreach ($y_info as $v_k => $v_v){
                        $y_num += $v_v['veh_type']['cewei_num'];
                    }
                    if($yuxia_num < $y_num){
                        $ztm[$k] = 2;
                        continue;
                    }
                    //循环装车
                    foreach ($veh_ids[$k] as $kk => $vv){
                        $data_OrderVeh = [
                            'car_id' => $v,
                            'is_load' => '1',
                        ];
//                            return ['$v'=>$v,'type_id'=>$vv['type_id'],'type_id1'=>'45'];
                        $z = OrderVeh::where('order_veh_id',$vv)->update($data_OrderVeh);
                        if($z){
                            $cewei_num = OrderVeh::with('veh_type')->where('order_veh_id',$vv)->get(['type_id']);
                            $yuxia_num_0 = $yuxia_num_0 - $cewei_num[0]['veh_type']->cewei_num;
                            $data_car = [
                                'yuxia_num' => $yuxia_num_0,
                            ];
                            $zz = Car::where('car_id',$v)->update($data_car);
                            $ztm[$k] = 0;
                        }else{
                            $ztm[$k] = 1;
                        }
                    }
                }

                $shuju = ['errorinfo'=>$ztm];
                return re_jiami(200,$shuju,$token);
            }
        }
    }

    /**
     * 发车
     * @param Request $request
     * @return array|string
     */

    public function send_car(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data = $info[0];
            $token  = $info[1];
            $car_id = $data['car_id'];
            //所有更改状态的订单id
            $order_ids = [];
            $i = 0;
            if(empty($car_id)){
                $shuju = ['errorinfo'=>'未选中'];
                return re_jiami(500,$shuju,$token);
            }
            $status = Car::where('car_id',$car_id)->limit(1)->get(['state','driver_id']);
            if($status[0]->state === '运输中' || $status[0]->state === '停运'){
                $shuju = ['errorinfo'=>'货车不是等待中'];
                return re_jiami(500,$shuju,$token);
            }
            if(empty($status[0]->driver_id)){
                $shuju = ['errorinfo'=>'请先向该货车分配一名司机，再进行发车'];
                return re_jiami(500,$shuju,$token);
            }
                $data_state = ['state'=>'运输中'];
            $z = Car::where('car_id',$car_id)->update($data_state);
            if ($z) {
              $d_car =  Car::where('car_id',$car_id)->get(['driver_id','car_name']);
                //创建司机推荐消息
                $user_msg  =[
                    'mg_id'=>0,
                    'title'=>'你有货车要开始配送',
                    'content'=>'你有货车'.$d_car[0]->car_name.',要开始配送',
                ];
                $mz =  Msg::create($user_msg);
                $ut_msg = [
                    'who'=>'driver',
                    'who_id'=>$d_car[0]->driver_id,
                    'msg_id'=>$mz->msg_id,
                    'status'=>'未读',
                ];
                $tz =  UserMsg::create($ut_msg);
                $order_veh =  Car::with('order_veh')->where('car_id',$car_id)->get(['car_id']);
                foreach ($order_veh[0]->order_veh as $k => $v){
                    if(in_array($v->order_id,$order_ids)){
                        continue;
                    }else{
                        $order_ids[$i] = $v->order_id;
//                        xieru( 'order_id'.$v->order_id);
                        $i += 1;
                        $order_state = ['process'=>'运输中'];
                        $zz = Order::where('order_id',$v->order_id)->update($order_state);
                        //向所属订单的用户推送消息
                        //创建用户推荐消息
                        $uo_msg = Order::where('order_id',$v->order_id)-get(['order_sn','user_id']);
                        $user_msg  =[
                            'mg_id'=>0,
                            'title'=>'你的订单已经开始配送',
                            'content'=>'你有订单号为'.$uo_msg[0]->order_sn.'已经开始配送,请关注物流信息',
                        ];
                        $mz =  Msg::create($user_msg);
                        $ut_msg = [
                            'who'=>'user',
                            'who_id'=>$uo_msg[0]->user_id,
                            'msg_id'=>$mz->msg_id,
                            'status'=>'未读',
                        ];
                        $mz =  UserMsg::create($ut_msg);
                    }
                }
                if ($zz) {
                    //同一个货车发车点一样
                    $send_info = Order::where('order_id',$order_ids[0])->get(['sender_start_point','sender_pointer_longtitude','sender_pointer_latitude']);
                    $send_point = $send_info[0]->sender_start_point;
                    $send_longtitude = $send_info[0]->sender_pointer_longtitude;
                    $send_latitude = $send_info[0]->sender_pointer_latitude;
                    $order_str  = implode(',',$order_ids);
//                    xieru('$order_str'.$order_str);
                    //增加物流信息car_wai中
                    $car_wai = [
                        'is_current'=>'2',
                        'car_id'=>$car_id,
                        'longitude'=>$send_longtitude,
                        'latitude'=>$send_latitude,
                        'address_name'=>$send_point,
                        'order_ids'=>$order_str,
                    ];
                       $zzz =  CarWai::create($car_wai);
                       if($zzz){
                       }else{
                           $shuju = ['errorinfo'=>'首次发车物流更新失败'];
                           return re_jiami(500,$shuju,$token);
                       }
                    $shuju = ['errorinfo'=>'已成功发车'];
                    return re_jiami(200,$shuju,$token);
                } else {
                    $shuju = ['errorinfo'=>'订单状态更新失败'];
                    return re_jiami(500,$shuju,$token);
                }
            }else{
                $shuju = ['errorinfo'=>'发车失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }


    /**
     * 卸车
     * @param Request $request
     * @return array|string
     */

    public function unload_car(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data = $info[0];
            $token  = $info[1];
            $veh_ids = $data['veh_id'];
            $car_ids =$data['car_ids'];
            //状态码
            $ztm = [];
            if(count($veh_ids) != count($car_ids)){
                $shuju = ['errorinfo'=>'数量不匹配'];
                return re_jiami('500',$shuju,$token);
            }else{
                foreach ($car_ids as $k => $v){
                    $status = Car::select('state','yuxia_num')->where('car_id',$v)->limit(1)->get();
                    //获取这个货车被装之前的余量
                    $yuxia_num = $status[0]->yuxia_num;
                    //更新car 车位余量变量
                    $yuxia_num_0 = $yuxia_num;
                    if($status[0]->state === '运输中' || $status[0]->state === '停运'){
                        $ztm[$k] = 3;
                        continue;
                    }
                    //循环装车
                    foreach ($veh_ids[$k] as $kk => $vv){
                        $data_OrderVeh = [
                            'is_load' => '0',
                        ];
//                            return ['$v'=>$v,'type_id'=>$vv['type_id'],'type_id1'=>'45'];
                        $z = OrderVeh::where('order_veh_id',$vv)->update($data_OrderVeh);

                            $cewei_num = OrderVeh::with('veh_type')->where('order_veh_id',$vv)->get(['type_id']);
                            $yuxia_num_0 = $yuxia_num_0 + $cewei_num[0]['veh_type']->cewei_num;

                            $data_car = [
                                'yuxia_num' => $yuxia_num_0,
                            ];
                            $zz = Car::where('car_id',$v)->update($data_car);
                            if($zz){
                                $ztm[$k] = 0;
                            }else{
                                $ztm[$k] = 1;
                            }

                    }
                }

                $shuju = ['errorinfo'=>$ztm];
                return re_jiami(200,$shuju,$token);
            }
        }
    }

    /**
     * 收车
     * @param Request $request
     * @return array|string
     */

    public function receive_car(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data = $info[0];
            $token  = $info[1];
            $cai_id = $data['cai_id'];
            $state = Car::where('car_id',$cai_id)->get(['state','unit_total_num']);
            $unit_total_num = $state[0]->unit_total_num;
            if($state[0]->state == '停运' || $state[0]->state == '等待中'){
                $shuju = ['errorinfo'=>'货车不是在运输中'];
                return re_jiami(500,$shuju,$token);
            }else{
                $car_state = ['state'=>'等待中','yuxia_num'=>$unit_total_num];
                $z = Car::where('car_id',$car_id)->update($car_state);
                //所在的订单order_id
                $order_veh =  Car::with('order_veh')->where('car_id',$car_id)->get(['car_id']);
                $order_ids = [];
                foreach ($order_veh[0]->order_veh as $k => $v){
                    if(in_array($v->order_id,$order_ids)){
                        continue;
                    }else{
                        $order_ids[$i] = $v->order_id;
                        $i += 1;
                    }
                }
                //用0 /1判断订单是否更改
                $is_gai = 1;//默认是改
                foreach ($order_ids as $k => $v){
                    $car_ids =  OrderVeh::where('order_id',$v)->get(['car_id']);
                    foreach ($car_ids as $kk =>$vv){
                        if($v->is_current !== '3'){
                            $is_gai =0;
                            break;
                        }
                    }
                    if($is_gai){
                        $order_gai = ['process'=>'待收车'];
                        $order_id =Order::where('order_id',$v)->update($order_gai);
                    }
                }
                if ($z) {
                    $shuju = ['errorinfo'=>'收车成功'];
                    return re_jiami(200,$shuju,$token);
                } else {
                    $shuju = ['errorinfo'=>'收车失败'];
                    return re_jiami(500,$shuju,$token);
                }
            }
        }
    }
    /**
     * 更改经纬度
     * @param Request $request
     * @return array|string
     */

    public function modify_location(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data = $info[0];
            $token  = $info[1];
            $longtitude = $data['longtitude'];
            $latitude = $data['latitude'];
            $order_state = ['longtitude'=>$longtitude,
                'latitude'=>$latitude];
            $z = Order::where('order_id',$order_id)->update($order_state);
            if ($z) {
                $shuju = ['errorinfo'=>'更改成功'];
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
    public function comment(Request $request)
    {
        if ($request->isMethod('post')){
            return shanchu($request);
        }
    }


    /**
     * 添加订单评价
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comment_create(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];

            $formData = $info['formData'];
            $sjk = $info['sjk'];
            luoji_zengjia($sjk,$formData,$token);

        }
    }

    /**
     * 删除订单中的车辆信息
     * @param Request $request
     * @return array
     */
    public function delCar(Request $request)
    {
        if ($request->isMethod('post')){
            $order_id = $request->input('order_id');
            $veh_ids = $request->input('veh_ids');
            $z = DB::table('order_veh')->where('order_id',$order_id)->whereIn('veh_id',$veh_ids)->delete();
            if ($z) {
                return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
            }else {
                return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'删除失败']),cut_token(session('_token')));
            }
        }

    }

    /**
     * 增加订单中的车辆
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCar(Request $request)
    {
        //$formData['order_id'] $formData['veh_id']
        if ($request->isMethod('post')) {
            $formData = $request->input('formData');
            $orderVeh =OrderVeh::where('order_id',$formData['order_id'])->where('veh_id',$formData['veh_id'])->get();

            if(!empty($orderVeh)){
                $veh_protection_price = $orderVeh[0]->veh_protection_price + $formData['veh_protection_price'];
                $upda_info = [
                    'veh_protection_price'=>$veh_protection_price,
                    ];
                $z = OrderVeh::where('order_id',$formData['order_id'])->where('veh_id',$formData['veh_id'])->update($upda_info);
                if($z){
                    return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
                }else{
                    return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'添加失败']),cut_token(session('_token')));
                }
            }else{
                $z = OrderVeh::create($formData);
                if($z){
                    return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
                }else{
                    return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'添加失败']),cut_token(session('_token')));
                }
            }
        }
    }

}
