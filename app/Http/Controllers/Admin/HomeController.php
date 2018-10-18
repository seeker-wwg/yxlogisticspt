<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Driver;
use App\Http\Models\User;
use App\Http\Models\Car;
use App\Http\Models\UserDay;
use App\Http\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * 司机 订单  用户 车辆
     */
    public function dsyc(Request $request)
    {
        if ($request->isMethod("post")) {
            $order_num = Order::get(['order_id']);
            $order_num = count($order_num);

            $driver_num = Driver::get(['driver_id']);
            $driver_num = count($driver_num);

            $car_num = Car::get(['car_id']);
            $car_num = count($car_num);

            $user_num = User::get(['user_id']);
            $user_num = count($user_num);
            $shuju = [
                'order_num'=>$order_num,
                'driver_num'=>$driver_num,
                'car_num'=>$car_num,
                'user_num'=>$user_num,
                ];
             return wei_jiami(200,$shuju);
        }
    }



    /**
     * 订单统计
     * @param Request $request
     * @param Uadd $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order_count(Request $request)
    {
        if ($request->isMethod('get')) {
            $order =Order::get();
            $order_shz = 0;
            $order_dfk = 0;
            $order_djc = 0;
            $order_dfc = 0;
            $order_ysz = 0;
            $order_dsc = 0;
            $order_ywc = 0;
            $order_yqx = 0;
            //定金总数
            $reserve_price = 0;
            $stay_price = 0;

            foreach ($order as $k =>$v){
                if($v->process == '审核中'){
                    $order_shz += 1;
                }elseif ($v->process == '待付款'){
                    $order_dfk += 1;
                }elseif ($v->process == '待接车'){
                    $order_djc += 1;
                    $reserve_price +=$v->reserve_price;
                }elseif ($v->process == '待发车'){
                    $order_dfc += 1;
                }elseif ($v->process == '运输中'){
                    $order_ysz += 1;
                }elseif ($v->process == '待收车'){
                    $order_dsc += 1;
                }elseif ($v->process == '已完成'){
                    $order_ywc += 1;
                    $stay_price +=$v->stay_price;
                }elseif ($v->process == '已取消'){
                    $order_yqx += 1;
                }

          }
          $shuju = [
            'order_shz' => $order_shz,
            'order_dfk' => $order_dfk,
            'order_djc' => $order_djc,
            'order_dfc' => $order_dfc,
            'order_ysz' => $order_ysz,
            'order_dsc' => $order_dsc,
            'order_ywc' => $order_ywc,
            'order_yqx' => $order_yqx,
            'reserve_price' => $reserve_price,
            'stay_price' => $stay_price,
          ];
            return wei_jiami(200,$shuju);

        }
    }

    /**
     * 获取近7天的用户数
     * @param Request $request
     * @return array
     */
    public function user_num(Request $request)
    {
        if ($request->isMethod('get')){
            $user_num =UserDay::orderBy('id','desc')->limit(7)->get(['user_num','created_at']);
            $shuju = ['user_num'=>$user_num];
            return wei_jiami(200,$shuju);
        }
    }

    /**
     * 创建今天的用户数
     * @param Request $request
     * @return array
     */
    public function create_user_num()
    {
            $user_num = User::get(['user_id']);
            $user_num =count($user_num);
            $user_data = ['user_num'=>$user_num];
            $z =UserDay::create($user_data);
    }
    /**
     * 添加用户地址信息
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return zengjia($request);
        }
    }
}
