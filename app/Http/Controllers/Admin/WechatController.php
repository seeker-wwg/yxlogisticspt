<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\LaravelPay\Facades\Pay;

class WechatController extends Controller
{
    /**
     * 角色列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jiesuan(Request $request)
    {
    if ($request->isMethod('get')){

        $config_biz = [
            'out_trade_no' => 'e2',
            'total_fee' => '1', // **单位：分**
            'body' => 'test body',
            'spbill_create_ip' => '8.8.8.8',
            'product_id' => '1223456',             // 订单商品 ID
        ];

//        $pay = new Pay($this->config);

        return Pay::driver('wechat')->gateway('scan')->pay($config_biz);

     }

    }

    public function return_url(Request $request)
    {
        return Pay::driver('alipay')->gateway('web')->verify($request->all());
    }

    public function notify(Request $request)
    {
        $verify = Pay::driver('wechat')->gateway('mp')->verify($request->getContent());

        if ($verify) {

            $verify['out_trade_no'];

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

            file_put_contents('notify.txt', "收到来自微信的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $verify['out_trade_no'] . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $verify['total_fee'] . "\r\n\r\n", FILE_APPEND);
        } else {
            //验证失败
            $shuju = ['errorinfo'=>'付款失败，数据库数据更新失败'];
            return wei_jiami(500,$shuju);
        }

        echo "success";
    }

}