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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\LaravelPay\Facades\Pay;

class WechatController extends Controller
{
/*
 * {

result_code: "FAIL",
}

return_code: "SUCCESS",
return_msg: "OK",
appid: "wx8430c9847053b3ec",
mch_id: "1338283501",
nonce_str: "dy1eGnZYtIdnSWcE",
sign: "40D84AAD6E5A51110CBA488CE7F1CD47",
result_code: "SUCCESS",
openid: "oEeJrwPt822ofynWSy3i_AgVOOv0",
is_subscribe: "N",
trade_type: "NATIVE",
bank_type: "CFT",
total_fee: "1",
fee_type: "CNY",
transaction_id: "4200000199201809218127557106",
out_trade_no: "8ba457edaad0d",
attach: [ ],
time_end: "20180921133332",
trade_state: "SUCCESS",
cash_fee: "1",
trade_state_desc: "支付成功"
 */
    public function find_order(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input('data');
            $out_trade_no =$data['out_trade_no'];
            $a = Pay::driver('wechat')->gateway('scan')->find($out_trade_no);
            if($a['result_code'] == 'SUCCESS'){
                //商户订单号
                       $out_trade_no = $a['out_trade_no'];
                        //① 实现订单由"未付款"变为"已付款"  并且判断一下是否为定金  或尾款
                        $order_info = Order::where('order_sn',$out_trade_no)->limit(1)->get()->toArray();
                        $d_trade_sn = $order_info[0];
                        if(empty($d_trade_sn)){
                            $rst = Order::where('order_sn',$out_trade_no)
                                ->update([
                                    'd_trade_sn' =>  $a['transaction_id'],
                                    'pay_stay_time' => date('Y-m-d H:i:s', strtotime($a['time_end'])),
                                    'process' => '待接车',
                                    'dingjin_payment_method' => '微信支付',
                                ]);
                            if ($rst) {
                                $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新成功'];
                                return wei_jiami(200,$shuju);
                            } else {
                                $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新失败'];
                                return wei_jiami(500,$shuju);
                            }
                        }else {
                            $w_rst = Order::where('w_order_sn', $out_trade_no)
                                ->update([
                                    'w_trade_sn' => $a['transaction_id'],
                                    'pay_time' => date('Y-m-d H:i:s', strtotime($a['time_end'])),
                                    'process' => '已完成',
                                    'weikuang_payment_method' => '微信支付',
                                ]);
                            if ($w_rst) {
                                $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新成功'];
                                    return wei_jiami(200,$shuju);
                            } else {
                                $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新失败'];                                     return wei_jiami(500,$shuju);
                                }
                        }
            }else{
                $shuju = ['errorinfo'=>'未查询到交易号'];                                                      return wei_jiami(500,$shuju);
            }
        }
    }
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
            if(empty($tg[0])){
                $err =  ['err'=>'订单尚未通过审核'];
            return re_jiami(500,$err,$token);
            }
            $out_trade_no =$tg[0]['order_sn'];
            //⑤ 对订单进行支付
            $config_biz = [
                'out_trade_no' =>$out_trade_no,
                'total_fee' => $tg[0]['reserve_price']*100, // **单位：分**
                'body' => '运输车辆预付金',
                'spbill_create_ip' => '8.8.8.8',
                'product_id' => 'yxwl' . time(),             // 订单商品 ID
            ];

            $wechat_url = Pay::driver('wechat')->gateway('scan')->pay($config_biz);

            $shuju = ['wechat_url'=>$wechat_url,'out_trade_no'=>$out_trade_no];
            return wei_jiami(200,$shuju);
        }
    }

    /**
     * 角色列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jiesuan(Request $request)
    {
    if ($request->isMethod('get')){
        //获取前端提交的信息
//        $datainfo = re_jiemi($request);
//        $info = $datainfo[0];
//        $token = $datainfo[1];
//        //需要判断订单的id是不是已通过审核
//        $tg = Order::select('w_order_sn','stay_price')->where('order_id',$info['order_id'])
//            ->get();
//        if(!$tg){
//            $err =  ['err'=>'订单尚未通过审核'];
//            return re_jiami(500,$err,$token);
//        }

        //⑤ 对订单进行支付
//        $config_biz = [
//            //商户订单号，商户网站订单系统中唯一订单号，必填
//            'out_trade_no' => $tg[0]['w_order_sn'],
//            'total_fee' => $tg[0]['stay_price']*100, // **单位：分**
//            'body' => '运输车辆尾款',
//            'spbill_create_ip' => '8.8.8.8',
//            'product_id' => 'yxwl' . time(),             // 订单商品 ID
//        ];

        $config_biz = [
            'out_trade_no' =>'8bd457edaad0d',
            'total_fee' => 1, // **单位：分**
            'body' => '运输车辆预付金',
            'spbill_create_ip' => '8.8.8.8',
            'product_id' => 'yxwl' . time(),             // 订单商品 ID
        ];

//        $pay = new Pay($this->config);

//        return Pay::driver('wechat')->gateway('scan')->pay($config_biz);
        $wechat_url = Pay::driver('wechat')->gateway('scan')->pay($config_biz);
        $out_trade_no ='8bb457edaad0d';
        $shuju = ['wechat_url'=>$wechat_url,'out_trade_no'=>$out_trade_no];
        return wei_jiami(200,$shuju);
     }

    }


    public function notify(Request $request)
    {
        $verify = Pay::driver('wechat')->gateway('scan')->verify($request->getContent());

        if ($verify) {
//            return $verify;
//            $verify['out_trade_no'];
            xieru($verify);


            //商户订单号
    /*        $out_trade_no = $verify['out_trade_no'];
            //支付宝交易号
//            $trade_no = htmlspecialchars($_GET['trade_no']);

            //① 实现订单由"未付款"变为"已付款"  并且判断一下是否为定金  或尾款
            $order_info = Order::where('order_sn',$out_trade_no)->limit(1)->get()->toArray();
            $d_trade_sn = $order_info[0];
//            $total_price = $order_info[0]['total_price'];
            if(empty($d_trade_sn)){
                $rst = Order::where('order_sn',$out_trade_no)
                    ->update([
//                        'd_trade_sn' => $trade_no,
//                        'pay_stay_time' => $_GET['timestamp'],
                        'process' => '待接车',
                        'dingjin_payment_method' => '微信支付',
                    ]);
//                if ($rst) {
//                    $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新成功'];
//                    return wei_jiami(200,$shuju);
//                } else {
//                    $shuju = ['errorinfo'=>'定金付款成功，数据库数据更新失败'];
//                    return wei_jiami(500,$shuju);
//                }
            }else{
                $rst = Order::where('w_order_sn',$out_trade_no)
                    ->update([
//                        'w_trade_sn' => $trade_no,
//                        'pay_time' => strtotime($_GET['timestamp']),
                        'process' => '已完成',
                        'weikuang_payment_method' => '微信支付',
                    ]);
//                if ($rst) {
//                    $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新成功'];
//                    return wei_jiami(200,$shuju);
//                } else {
//                    $shuju = ['errorinfo'=>'尾款付款成功，数据库数据更新失败'];
//                    return wei_jiami(500,$shuju);
//                }
            }*/

            file_put_contents('data.txt', "收到来自微信的异步通知\r\n", FILE_APPEND);
            file_put_contents('data.txt', '订单号：' . $verify['out_trade_no'] . "\r\n", FILE_APPEND);
            file_put_contents('data.txt', '订单金额：' . $verify['total_fee'] . "\r\n\r\n", FILE_APPEND);
        } else {
            //验证失败
            file_put_contents('data.txt', '收到来自微信的异步通知：'. "\r\n\r\n", FILE_APPEND);
        }

        echo "success";
    }

}