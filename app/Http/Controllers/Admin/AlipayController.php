<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Article;
use App\Http\Models\Driver;
use App\Http\models\Order;
use App\Http\models\OrderVeh;
use App\Http\models\Vehicle;
use App\Tools\Cart;
use EchoBool\AlipayLaravel\Facades\Alipay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AlipayController extends Controller
{
    /**
     * 购物车"去结算"定金支付宝操作
     * @param Request $request
     */
    public function cart_reserve_jiesuan(Request $request)
    {
        if ($request->isMethod('post')) {
            //获取前端提交的信息
         $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            //需要判断订单的id是不是已通过审核
            $tg = Order::select('order_sn','reserve_price')->where('order_id',$info['id'])->where('process','待付款')->get();
            if(!$tg){
               $err =  ['err'=>'订单尚未通过审核'];
                return re_jiami(500,$err,$token);
            }

            //① 获得购物车信息
            $cart = new Cart();
            $cartinfo = $cart->getCartInfo();
            //③ 形成订单详情表信息order_veh
//            veh_name'=>'运车名称','veh_count=>数量','veh_protection_price'=>'保价','veh_price'=>'运费'
            foreach ($cartinfo as $v) {
                OrderVeh::create([
                    'order_id' => $info['id'],
                    'type_id' => $v['type_id'],
                    'veh_price' => $v['veh_price'],
                ]);
            }
            //④ 清空购物车信息
            $cart->delall();

            //⑤ 对订单进行支付
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $tg[0]['order_sn'];
            //订单名称，必填
            $subject = 'yxwl' . time();
            //付款金额，必填
            $total_amount = $tg[0]['reserve_price'];
            //商品描述，可空
            $body = '';

            $customData = json_encode(['model_name' => 'ewrwe', 'id' => 121]);//自定义参数
            $response = Alipay::tradePagePay($subject, $body, $out_trade_no, $total_amount, $customData);
            //输出表单
            return $response['redirect_url'];
        }
    }

    /**
     * 购物车"去结算剩余"支付宝操作
     * @param Request $request
     */
    public function cart_jiesuan(Request $request)
    {
        if ($request->isMethod('post')) {
            //获取前端提交的信息
            $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            //需要判断订单的id是不是已通过审核
            $tg = Order::select('order_sn','stay_price')->where('order_id',$info['id'])
                ->get();
            if(!$tg){
                $err =  ['err'=>'订单尚未通过审核'];
                return re_jiami(500,$err,$token);
            }

            //⑤ 对订单进行支付
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $tg[0]['order_sn'];
            //订单名称，必填
            $subject = 'yxwl' . time();
            //付款金额，必填
            $total_amount = $tg[0]['stay_price'];
            //商品描述，可空
            $body = '';

            $customData = json_encode(['model_name' => 'ewrwe', 'id' => 121]);//自定义参数
            $response = Alipay::tradePagePay($subject, $body, $out_trade_no, $total_amount, $customData);
            //输出表单
            return $response['redirect_url'];
        }
    }

    /**
     * 购物车"去结算剩余"支付宝操作
     * @param Request $request
     */
    public function find_order(Request $request)
    {
        if ($request->isMethod('post')) {
            //获取前端提交的信息
            $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            //需要判断订单的id是不是已通过审核
            $tg = Order::select('order_sn','stay_price')->where('order_id',$info['id'])
                ->get();
            if(!$tg){
                $err =  ['err'=>'订单尚未通过审核'];
                return re_jiami(500,$err,$token);
            }

            //⑤ 对订单进行支付
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $tg[0]['order_sn'];
            //订单名称，必填
            $subject = 'yxwl' . time();
            //付款金额，必填
            $total_amount = $tg[0]['stay_price'];
            //商品描述，可空
            $body = '';

            $customData = json_encode(['model_name' => 'ewrwe', 'id' => 121]);//自定义参数
            $response = Alipay::tradePagePay($subject, $body, $out_trade_no, $total_amount, $customData);
            //输出表单
            return $response['redirect_url'];
        }
    }

    /**
     * 支付宝向商家发起的get同步请求
     * @param Request $request
     */
    public function return_url(Request $request)
    {
        $result = Alipay::notify($_GET);
        /* 实际验证过程建议商户添加以下校验。
            1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
            2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
            3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
            4、验证app_id是否为该商户本身。
         */
        if ($result) {//验证成功
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);

            //① 实现订单由"未付款"变为"已付款"  并且判断一下是否为定金  或尾款
            $order_info = Order::select('d_trade_sn')->where('order_sn',$out_trade_no)->limit(1)->get()->toArray();
            $d_trade_sn = $order_info[0]['d_trade_sn'];
//            $total_price = $order_info[0]['total_price'];
            if(empty($d_trade_sn)){
                    $rst = Order::where('order_sn',$out_trade_no)
                        ->update([
                            'd_trade_sn' => $trade_no,
                            'pay_stay_time' => $_GET['timestamp'],
                            'process' => '待接车',
                            'dingjin_payment_method' => '支付宝支付',
                        ]);
                        if ($rst) {
                            $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新成功'];
                                return wei_jiami(200,$shuju);
                        } else {
                            $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新失败'];
                            return wei_jiami(500,$shuju);
                        }
            }else{
                $rst = Order::where('order_sn',$out_trade_no)
                        ->update([
                            'w_trade_sn' => $trade_no,
                            'pay_time' => strtotime($_GET['timestamp']),
                            'process' => '已完成',
                            'weikuang_payment_method' => '支付宝支付',
                        ]);
                if ($rst) {
                    $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新成功'];
                    return wei_jiami(200,$shuju);
                } else {
                    $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新失败'];
                    return wei_jiami(500,$shuju);
                }
            }
        } else {
            //验证失败
            $shuju = ['errorinfo'=>'付款失败，数据库数据更新失败'];
            return wei_jiami(500,$shuju);
        }

    }
}
