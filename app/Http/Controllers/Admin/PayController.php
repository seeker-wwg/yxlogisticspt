<?php

namespace App\Http\Controllers\Admin;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    /**
     * 角色列表展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jiesuan(Request $request)
    {
    if ($request->isMethod('get')){

        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject' => 'test subject',
        ];

        return Pay::driver('alipay')->gateway('web')->pay($order);
    }

    }

    public function return_url(Request $request)
    {
        return Pay::driver('alipay')->gateway('web')->verify($request->all());
    }

    public function notify_url(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Pay::driver('alipay')->gateway('web')->verify($request->all())) {
                // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
                // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
                // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
                // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
                // 4、验证app_id是否为该商户本身。
                // 5、其它业务逻辑情况
                file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
                file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
                file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
            } else {
                file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
            }

            echo "success";
        }
    }
}