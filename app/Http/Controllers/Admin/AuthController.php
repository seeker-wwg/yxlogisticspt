<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //用户点击微信登录按钮后，调用此方法请求微信接口
    public function oauth(Request $request)
    {
        return \Socialite::with('weixinweb')->redirect();
    }


    //微信的回调地址
    public function callback(Request $request)
    {
        $oauthUser = \Socialite::driver('weixinweb')->user();

        // 在这里可以获取到用户在微信的资料
        dd($oauthUser);

        // 接下来处理相关的业务逻辑
    }

}