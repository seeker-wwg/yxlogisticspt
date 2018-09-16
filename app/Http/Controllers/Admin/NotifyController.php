<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Yansongda\LaravelNotificationWechat\WechatChannel;
use Yansongda\LaravelNotificationWechat\WechatMessage;
use Yansongda\LaravelNotificationWechat\Credential;

class NotifyController extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [WechatChannel::class];
    }

    public static function toWechat($notifiable)
    {
        $accessToken = new Credential('wxa4ba0c821f961e47', '1239c5aeb90a8996289305702015450a');
        $accessToken =$accessToken->getAccessToken();

        $data = [
            'first' => 'Test First',
            'keyword1' => 'keyword1',
            'keyword2' => 'keyword2',
            'keyword3' => ['keyword3', '#000000'],
            'remark' => ['Test remark', '#fdfdfd'],
        ];

        $a =  WechatMessage::create($accessToken)
            ->to('oWbEz1vS3pT1IvrR-nElCxz5wqqs')
            ->template("I93GAKQaaodpW_NL6y3JtxQUgS28agb7c2FMvZ8fFGQ")
            ->url('http://github.com/yansongda')
            ->data($data);
        dd($a);
    }

}