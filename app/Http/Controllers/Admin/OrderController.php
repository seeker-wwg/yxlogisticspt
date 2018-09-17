<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Order;
use App\Http\models\OrderComment;
use App\Http\models\OrderVeh;
use App\Http\models\OrderCar;
use App\Http\models\Vehicle;
use App\Http\Models\Manager;
use App\Http\Models\Freight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Models\User;
use App\Http\Models\Car;
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
            $freight_id = $info['freight_id'];
            $order_sn = uniqid('');
            //计算总价
            //1.车的费用
            $car_cost = Freight::whereIn('freight_id',$freight_id)->get(['freight_cost','type_id'])->toArray();
            $car_costs = 0;
            foreach ($car_data as $k => $v){
                foreach ($car_cost as $kk => $vv) {
                    if ($v['type_id'] == $vv['type_id']) {
                        $car_costs += $vv['freight_cost'];
                    }
                }
            }

            //送车上门的费用
            if($formData['sender_type'] == '平台派人上门取车'){
                $sender_cost = Region::select('carry_out_cost')->find($info['sender_id']);
                $sender_cost = $sender_cost->carry_out_cost;
            }
            if($formData['receive_type'] == '平台派人送车上门'){
                $receive_cost = Region::select('carry_out_cost')->find($info['receive_id']);
                $receive_cost = $receive_cost->carry_out_cost;
            }
            //总额
            $total_price = $car_costs + $sender_cost + $receive_cost + $formData['baoe_cost'] + $formData['baofei_cost'];

            if($formData['total_price'] !== $total_price){
                $formData['total_price'] = $total_price;
            }

            //2.上门取车

            $formData['order_sn'] = $order_sn;
            if(!empty($car_data)){
                //实例化购物车类对象
                $cart = new Cart();
                //添加课程到购物车
                $cart -> add($car_data);
            }
           luoji_zengjia($sjk,$formData,$token);
        }
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $query = $info['query'];
            foreach ($query as $k =>$v){
                $key  = $k;
                $value = $v;
            }
            //在这里判断
            $formData = $info['formData'];
//            if(array_key_exists('car_id', $formData)){
////                $order_id = $ziyuan->select('order_id')->where($key,$value)->get();
////                $order_id = $order_id[0]->order_id;
////                $Info = Order::with('car')->where('order_id',1)->get(['order_id']);
////                $info = $Info[0]->car;
////                $huo_num = 0;
////                foreach ($info as $k =>$v){
////                    $huo_num += $v->yuxia_num;
////                }
//                //货车的车位
//                $huo_num = 0;
//                $y_num = 0;
//                if(is_array($formData['car_id'])){
//                    $info = Car::whereIn('car_id',$formData['car_id'])->get(['yuxia_num']);
//                    foreach ($info as $k =>$v){
//                        $huo_num += $v->yuxia_num;
//                    }
//                }else{
//                    $info = Car::where('car_id',$formData['car_id'])->get(['yuxia_num']);
//                    $huo_num = $info[0]->yuxia_num;
//                }
//                //被运输的车位
//                $order_id = $ziyuan->select('order_id')->where($key,$value)->get();
//                $order_id = $order_id[0]->order_id;
//                $y_info = OrderVeh::with('veh_type')->where('order_id',$order_id)->get(['type_id','veh_count']);
//                foreach ($y_info as $k => $v){
//                    $y_num += $v->veh_count * $v->veh_type->cewei_num;
//                }
//                if($huo_num < $y_num) {
//                    $shuju = ['errorinfo' => '货车单位不足成功'];
//                    return re_jiami(200, $shuju, $token);
//                }else{
//                    //增加关联表的数据
//                    if(is_array($formData['car_id'])){
//                        foreach ($formData['car_id'] as $k =>$v){
//                            $data = [
//                                'order_id'=>$order_id,
//                                'car_id' => $k,
//                            ];
//                            OrderCar::create($data);
//                        }
//                    }else{
//                        $data = [
//                            'order_id'=>$order_id,
//                            'car_id' => $formData['car_id'],
//                        ];
//                        OrderCar::create($data);
//                    }
//                    unset($formData['car_id']);
//                }
//
//            }
            $sjk = $info['sjk'];
            $ziyuan = orm_sjk($sjk);
            if( !is_object ($ziyuan)){
                $shuju = ['errorinfo'=>'未找到数据库'];
                return re_jiami(200,$shuju,$token);
            }
            $z = $ziyuan->where($key,$value)->update($formData);;
            if ($z) {
                $shuju = ['errorinfo'=>'修改成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                //删除关联表的数据
                $shuju = ['errorinfo'=>'修改失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }

    /**
     *分配车
     * @param Request $request
     * @return array
     */
    public function assign_car(Request $request)
    {
        if ($request->isMethod('post')){
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
//            $key = $info['key'];
//            $value = $info['value'];
            $order_id = $info['order_id'];
            if(array_key_exists('car_id', $info)){
                //货车的车位
                $huo_num = 0;
                $y_num = 0;
                if(is_array($info['car_id'])){
                    $info = Car::whereIn('car_id',$info['car_id'])->get(['yuxia_num']);
                    foreach ($info as $k =>$v){
                        $huo_num += $v->yuxia_num;
                    }
                }else{
                    $info = Car::where('car_id',$info['car_id'])->get(['yuxia_num']);
                    $huo_num = $info[0]->yuxia_num;
                }
                //被运输的车位

                $y_info = OrderVeh::with('veh_type')->where('order_id',$order_id)->get(['type_id']);
                foreach ($y_info as $k => $v){
                    $y_num += $v->veh_type->cewei_num;
                }
                if($huo_num < $y_num) {
                    $shuju = ['errorinfo' => '货车单位不足成功'];
                    return re_jiami(200, $shuju, $token);
                }else{
                    //增加关联表的数据
                    if(is_array($info['car_id'])){
                        foreach ($formData['car_id'] as $k =>$v){
                            $data = [
                                'order_id'=>$order_id,
                                'car_id' => $k,
                            ];
                            OrderCar::create($data);
                        }
                    }else {
                        $data = [
                            'order_id' => $order_id,
                            'car_id' => $formData['car_id'],
                        ];
                        OrderCar::create($data);
                    }
                    //去car类请求更改
                    $shuju = ['errorinfo' => '货车单位充足'];
                    return re_jiami(200, $shuju, $token);
                }
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
            return shanchu($request);
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
                        ];
//                            return ['$v'=>$v,'type_id'=>$vv['type_id'],'type_id1'=>'45'];
                        $z = OrderVeh::where('order_veh_id',$vv)->update($data_OrderVeh);
                        if($z){
                            $cewei_num = OrderVeh::with('veh_type')->where('order_veh_id',$vv)->get(['type_id']);
                            $yuxia_num_0 = $yuxia_num_0 - $cewei_num[0]['veh_type']->cewei_num;
                            xieru($cewei_num[0]['veh_type']->cewei_num.'---'.$yuxia_num_0);
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
            $car_ids = $data['car_ids'];
            $order_id = $data['order_id'];
            foreach ($car_ids as $k => $v){
                $data_state = ['state'=>'运输中'];
                Car::where('car_id',$v)->update($data_state);
            }
            $order_state = ['process'=>'运输中'];
            $z = Order::where('order_id',$order_id)->update($order_state);
            if ($z) {
                $shuju = ['errorinfo'=>'发车成功'];
                return re_jiami(200,$shuju,$token);
            } else {
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
            $car_ids = $data['car_ids'];
            $order_id = $data['order_id'];
            //先是循环判断
            foreach ($car_ids as $k => $v){
                $car_info = Car::where('car_id',$v)->get(['state']);
                if($car_info[0]->state === '运输中'){
                    $shuju = ['errorinfo'=>'有货车在运输中'];
                    return re_jiami(500,$shuju,$token);
                }
            }
            //再是循环卸车
            foreach ($car_ids as $k => $v){
                $car_state = ['state'=>'等待中'];
                $z = Car::where('car_id',$v)->update($car_state);
            }
            $order_state = ['process'=>'待收车'];
            $z = Order::where('order_id',$order_id)->update($order_state);
            if ($z) {
                $shuju = ['errorinfo'=>'卸车成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'卸车失败'];
                return re_jiami(500,$shuju,$token);
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
            $order_id = $data['order_id'];
            $order_state = ['process'=>'已完成'];
            $z = Order::where('order_id',$order_id)->update($order_state);
            if ($z) {
                $shuju = ['errorinfo'=>'收车成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'收车失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }
    /**
     * 更改经纬度
     * @param Request $request
     * @return array|string
     */

    public function receive_car(Request $request)
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
