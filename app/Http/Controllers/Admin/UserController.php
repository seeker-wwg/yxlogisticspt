<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\User;
use App\Http\Models\Manager;
use App\Http\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\models\TempCount;
use App\Http\models\TempPhone;
use App\Http\models\ZcTempPhone;
use App\Http\models\TempUCount;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //客户登录
    public function login(Request $request)
    {
        if ($request->isMethod('post')){

            //接收前端的参数
            $max_pwd = $request->all();
            unset($max_pwd['role']);
            //验证
            if (\Auth::guard('frontu')->attempt($max_pwd)) {


                //手机号登录
                if ($request->has('phone')) {
                    if ($mg_id = User::select('user_id', 'user_name','token','title_image')->where('phone', $max_pwd['phone'])->limit(1)->get()->toArray()) {

                      
                        $token =  encrypt_pass($mg_id[0]['token'],$max_pwd['password']);
                        $token_time = date('Y-m-d H:i:s', time()+7200);

                        User::where('user_id',$mg_id[0]['user_id'])->update(['token_time'=>$token_time]);


                        //登录成功进行记录(统计每天每天用户)

                        return ['status' => 200,
                            'token' => $mg_id[0]['token'],
                            'mi_token'=>$token,
                            'user_id' => $mg_id[0]['user_id'],
                            'user_name' => $mg_id[0]['user_name'],
                            'title_image' => $mg_id[0]['title_image'],
                        ];
                    }



                    // 邮箱登录
                } elseif ($request->has('email')) {
                    if ($mg_id = User::select('user_id', 'user_name','token','title_image' )->where('email', $max_pwd['email'])->limit(1)->get()->toArray()) {


                        $token =  encrypt_pass($mg_id[0]['token'],$max_pwd['password']);
                        $token_time = date('Y-m-d H:i:s', time()+3600*2);

                        User::where('user_id',$mg_id[0]['user_id'])->update(['token_time'=>$token_time]);
                        return ['status' => 200,
                            'token' => $token,
                            'user_id' => $mg_id[0]['user_id'],
                            'user_name' => $mg_id[0]['user_name'],
                            'title_image' => $mg_id[0]['title_image']
                        ];
                    }
                }
            } else {

                //登录错误次数
                //输出5次后  过一天后还可以
                $deadline = date("Y-m-d H:i:s", time() + 24*60*60);


                if ($t_ucount = TempUCount::select('count')->where('phone', session('_token'))->first()){
                    $count= $t_ucount->count+1;
                    TempUCount::where('phone', session('_token'))->update(['count' => $count]);
                }else{
                    $count = 1;
                    $form_data = [
                        'phone' =>session('_token'),
                        'count' => $count,
                        'deadline' => $deadline
                    ];
                    TempUCount::create($form_data);
                }
                $sy = 5 - $count;
                $temp_ucount = TempUCount::where('phone',session('_token'))->first();
                if (time() > strtotime($temp_ucount->deadline)){
                    $count = 0;
                    TempUCount::where('phone', session('_token'))->update(['count' => $count, 'deadline' => $deadline]);
                }

                $errorinfo = '账号或密码错误' . $count . '次，还有' . $sy . '机会';
                if ($count >= 5) {
                    $errorinfo = '今日已经输错超过5次，账号已被锁定，请使用短信登录';
                }
                return wei_jiami(500,['errorinfo'=>$errorinfo]);
            }
        }
    }

    public function sendSMS(Request $request){

        if ($request->isMethod('post')) {
            $phone = $request->input('phone');
            $code = rand(100000, 999999);
            if ($mg_id = User::select('user_id')->where('phone', $phone)->limit(1)->get()->toArray()) {
                if (sendTemplateSMS($phone, array($code), "195514")){
                    $deadline = date("Y-m-d H:i:s", time() + 5 * 60);
                    if (TempPhone::where('phone', $phone)->first()) {
                        TempPhone::where('phone', $phone)->update(['code' => $code, 'deadline' => $deadline]);
                        return ['status' => 200];
                    } else {
                        $form_data = [
                            'phone' => $phone,
                            'code' => $code,
                            'deadline' => $deadline
                        ];
                        TempPhone::create($form_data);
                        return ['status' => 200];
                    }
                }else{
                    return wei_jiami(500,['errorinfo' => '验证码发送失败']);
                }


            } else {
                return wei_jiami(500,['errorinfo' => '手机号尚未注册']);
            }
        }
    }

    public function zc_sendSMS(Request $request){

        if ($request->isMethod('post')) {
            $phone = $request->input('phone');
            return send_sms($phone);
        }
    }


    public function checkCode(Request $request)
    {
        if ($request->isMethod('post')) {
            $phone = $request->input('phone');
            $phone_code = $request->input('phone_code');
            $temp_phone = TempPhone::where('phone', $phone)->first();
            //验证码不正确或验证码过期五分钟
            if ($temp_phone->code != $phone_code || time() > strtotime($temp_phone->deadline)) {
                //错误的次数

                // 用于 过一天之后 错误次数清零
                $deadline = date("Y-m-d H:i:s", time() + 24*60*60);


                if ($t_count = TempCount::select('count')->where('phone', $phone)->first()){
                    $count= $t_count->count+1;
                    TempCount::where('phone', $phone)->update(['count' => $count]);
                }else{
                    $count = 1;
                    $form_data = [
                        'phone' => $phone,
                        'count' => $count,
                        'deadline' => $deadline
                    ];
                    TempCount::create($form_data);
                }
                $sy = 5 - $count;
                //验证码输入错误 次，今日您还能再获取 次
                $errorinfo = '验证码输入错误' . $count . '次，今日您还能再获取' . $sy . '次';
                if ($count >= 5) {
                    $errorinfo = '您已经连续输错了5次验证码，账号已被锁定，请联系管理员进行解锁';
                }
                // 用于 过一天之后 错误次数清零
                $temp_count = TempCount::where('phone', $phone)->first();
                if (time() > strtotime($temp_count->deadline)){
                    $count = 0;
                    //更改时间
                    TempCount::where('phone', $phone)->update(['count' => $count, 'deadline' => $deadline]);
                }
                return wei_jiami(500,['errorinfo'=>$errorinfo]);



            } else {
                $mg_id = User::select('user_id', 'user_name','token','title_image','title_image')->where('phone', $phone)->limit(1)->get()->toArray();
                $token =  encrypt_pass($mg_id[0]['token'],$phone_code);
                $token_time = date('Y-m-d H:i:s', time()+3600*2);

                User::where('user_id',$mg_id[0]['user_id'])->update(['token_time'=>$token_time]);
                return ['status' => 200,
                    'token' => $token,
                    'user_id' => $mg_id[0]['user_id'],
                    'user_name' => $mg_id[0]['user_name'],
                    'title_image' => $mg_id[0]['title_image'],
                ];
            }
        }
    }


    /**
     * 用户退出系统
     * @param Request $request
     */
    public function logout(Request $request)
    {
        \Auth::guard('frontu')->logout();//清除session
        return ['status' => 200];
    }

    /**
     * 更改密码
     * @param Request $request
     */
    public function update_pw(Request $request)
    {
        if ($request->isMethod("post")) {
            $info = $request->all();
            $phone = $info['phone'];
            $password = $info['password'];
            $phone_code = $info['phone_code'];
            if(empty($phone_code)){
                return  wei_jiami(500,['errorinfo'=>'请先获取验证码']);
            }
            if(!phone_yz($phone,'user_id')){
                return  wei_jiami(500,['errorinfo'=>'该手机号未被注册']);
            }
            $temp_phone = ZcTempPhone::where('phone', $phone)->first();
            //验证码不正确或验证码过期五分钟
            if ($temp_phone->code != $phone_code || time() > strtotime($temp_phone->deadline)) {
                return wei_jiami(500,['errorinfo' => '验证码错误或验证码已过期']);
            }

            $formData = ['password'=>bcrypt($password)];

            $z = User::where('phone',$phone)->update($formData);
            if ($z) {
                $shuju = ['errorinfo'=>'密码更改成功'];
                return wei_jiami(200,$shuju);
            } else {
                $shuju = ['errorinfo'=>'密码更改失败'];
                return wei_jiami(500,$shuju);
            }
        }
    }

    /**
     * 注册
     * @param Request $request
     */
    public function register(Request $request)
    {
        if ($request->isMethod("post")) {
            $info = $request->all();
            $phone = $info['phone'];
            $password1 = $info['password1'];
            $password2 = $info['password2'];
            $phone_code = $info['phone_code'];
            if(empty($phone_code)){
                return  wei_jiami(500,['errorinfo'=>'请先获取验证码']);
            }
            if(phone_yz($phone,'user_id')){
                return  wei_jiami(500,['errorinfo'=>'该手机号已被注册']);
            }

            if($password1 != $password2){
                return  wei_jiami(500,['errorinfo'=>'输入的密码不一致']);
            }
            $temp_phone = ZcTempPhone::where('phone', $phone)->first();
            //验证码不正确或验证码过期五分钟
            if ($temp_phone->code != $phone_code || time() > strtotime($temp_phone->deadline)) {
                return wei_jiami(500,['errorinfo' => '验证码错误或验证码已过期']);
            }
            $formData= ['phone'=>$phone];
            $formData['password'] = bcrypt($password1);

            $dd = substr(strval(rand(10000,19999)),1,4);
            $token1 = md5($dd);
            $formData['token'] = $token1;
            $z = User::create($formData);
            if ($z) {
                $token =  encrypt_pass($token1,$password1);
                $token_time = date('Y-m-d H:i:s', time()+3600*2);

                User::where('user_id',$z->user_id)->update(['token_time'=>$token_time,'user_name'=>'游客'.$z->user_id]);
                $shuju = [
                    'mi_token'=>$token,
                    'user_id' => $z->user_id,
                    'user_name' => '游客'.$z->user_id,
                ];
                return wei_jiami(200,$shuju);
            } else {
                $shuju = ['errorinfo'=>'注册失败'];
                return wei_jiami(500,$shuju);
            }
        }
    }
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod("post")) {
            return jiami_shousuo($request);
        }
    }
    /**
     * 添加培养信息
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $sjk = $info['sjk'];
            $ziyuan = orm_sjk($sjk);
            $formData = $info['formData'];
            if(phone_yz($formData['phone'],'user_id')){
                return  re_jiami(500,['errorinfo'=>'该手机号已被注册'],$token);
            }
            if(array_key_exists('password', $formData)){
                $formData['password'] = bcrypt($formData['password']);
            }
            $dd = substr(strval(rand(10000,19999)),1,4);
            $token1 = md5($dd);
            $formData['token'] = $token1;
            if( !is_object ($ziyuan)){
                return  re_jiami(500,['errorinfo'=>'未找到查询数据库的字段'],$token);
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
    }

    /**
     * 修改培养信息
     * @param Request $request
     * @param User $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            return xiugai($request);
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
}
