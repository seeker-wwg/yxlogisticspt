<?php
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Models\Order;
use App\Http\Models\OrderVeh;
use App\Http\Models\Car;
use App\Http\Models\Help;
use App\Http\Models\Manager;
use App\Http\Models\Driver;
use App\Http\Models\Permission;
use App\Http\Models\CarTypeNum;
use App\Http\Models\Region;
use Illuminate\Support\Facades\DB;
use zgldh\QiniuStorage\QiniuStorage;
use App\Http\Models\Freight;
use App\Http\Models\CarWai;
use App\Http\Models\Protocol;
use App\Http\Models\VehType;
use Illuminate\Support\Facades\Session;
use App\Tools\WcNotify;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// 上传页面视图
Route::get('/',function ()
{
    return view('weixin');
});

//【后台路由群组】
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
// form提交到控制器路由
    Route::match(['get', 'post'], 'upload/upload_car_execel','UploadController@upload_car_execel');
    Route::group(['middleware'=>'loginyz'],function() {
        //用户登录系统
        Route::post('user/login','UserController@login');
        Route::post('user/sendSMS',  'UserController@sendSMS');

        Route::post('user/checkCode','UserController@checkCode');

        //司机登录系统
        Route::post('driver/login','DriverController@login');
        Route::post('driver/sendSMS','DriverController@sendSMS');
        Route::post('driver/checkCode','DriverController@checkCode');
        //管理员登录系统
        Route::post('manager/login','ManagerController@login');
        Route::post('manager/sendSMS','ManagerController@sendSMS');
        Route::post('manager/checkCode','ManagerController@checkCode');
    });
    Route::post('user/register','UserController@register');
    Route::post('user/zc_sendSMS',  'UserController@zc_sendSMS');
    Route::post('user/update_pw',  'UserController@update_pw');
    //用户点击登录按钮时请求的地址
    Route::get('auth/oauth', 'AuthController@oauth');

// 微信接口回调地址
    Route::get('auth/callback', 'AuthController@callback');


    //首页
    Route::post('home/dsyc', 'HomeController@dsyc');
    Route::get('home/order_count', 'HomeController@order_count');
    Route::get('home/user_num', 'HomeController@user_num');
    //用户或管理员退出
    Route::post('user/logout','UserController@logout');
    Route::post('driver/logout','DriverController@logout');
    Route::post('manager/logout','ManagerController@logout');


    Route::post( 'region/index','RegionController@index');

    Route::post('banner/index','BannerController@index');
    Route::post('wbanner/index','WBannerController@index');
    Route::post( 'field/index','FieldController@index');

    Route::post( 'freight/index','FreightController@index');
    Route::post( 'freight/refresh','FreightController@refresh');

    Route::post( 'protocol/index','ProtocolController@index');

    Route::post('help/index','HelpController@index');
    Route::post( 'vehtype/index','VehTypeController@index');

    //支付功能_________**************************************************************
    //支付完成的get请求----支付宝
    Route::get('alipay/return_url', 'AlipayController@return_url');
//    //支付完成的post请求
//    Route::get('alipay/notify_url', 'AlipayController@notify_url');
    //支付功能--结算
    Route::post('alipay/cart_reserve_jiesuan', 'AlipayController@cart_jiesuan');
    Route::post('alipay/cart_jiesuan', 'AlipayController@cart_jiesuan');
    //----微信

    //支付完成的post请求
    Route::post('wechat/notify', 'WechatController@notify');
    //支付功能--结算
//    Route::post('wechat/cart_reserve_jiesuan', 'WechatController@cart_jiesuan');
    Route::get('wechat/jiesuan', 'WechatController@jiesuan');

    Route::post('wechat/cart_reserve_jiesuan', 'WechatController@cart_reserve_jiesuan');
    Route::post('wechat/find_order', 'WechatController@find_order');
    //*************************************************************************************
    //上门取送车计费规则
    Route::post('price/create','PriceController@create');
    Route::post('price/update','PriceController@update');
    Route::post('price/delete','PriceController@delete');
    Route::post( 'price/index','PriceController@index');

    //获取接口列表


    Route::get( 'pay/jiesuan','PayController@jiesuan');
    Route::get( 'pay/return_url','PayController@return_url');
    Route::post( 'pay/notify_url','PayController@notify_url');
    //未加密的
    Route::post('upload/w_upload_img','UploadController@w_upload_img');

    //获取单一字段信息


    Route::post('field/index','FieldController@index');
    //测试
    Route::get( 'jia/mi',function (Request $request) {
//        $disk = QiniuStorage::disk('qiniu');
//            $qiniu = new \Qiniu\Auth('3ajVsvxYFuD5JnPbgptYoG4SBUnaQxhW1s5QYPck','43f4nuDWsO8z09NXtRe4PtAypYZhf3LxtYx6vEri');
//        $qiniu= $disk->privateDownloadUrl('3ajVsvxYFuD5JnPbgptYoG4SBUnaQxhW1s5QYPck\',\'43f4nuDWsO8z09NXtRe4PtAypYZhf3LxtYx6vEri');
//        return  $disk->uploadToken();//---------有用
//        $Info = User::with('uadd')->where('user_id',12)->get();
//        if(empty($Info[0])){
//        $str = "this(8625010) is2220394 15838689541a number, and the another is here(09978625000) ,the phone number is 18064074452 and 13899555555。这是中文，这里有个13239323232的手机号,还有一个188779988441这是12位8613322114455的。这里又是一个手机号86-18064074455。还有一个区号分开写的0997-8625001hahaha";
//        $as =findThePhoneNumbers($str);
//            ;
//        dd(strlen(bcrypt(md5('123456'))));//jiemi
        //$2y$10$xjnZjtefEvP5RKI3d71ade/KRYwEoNW74nC35ZQmW/lCmYSfe1yiK
//        dd(encrypt('$2y$10$xjnZjtefEvP5RKI3d71ade/KRYwEoNW74nC35ZQmW/lCmYSfe1yiK'));


        //$2y$10$xjnZjtefEvP5RKI3d71ade/KRYwEoNW74nC35ZQmW/lCmYSfe1yiK
//        dd(encrypt('22051440202'));
//        $formData= ['driver_name'=>'ddd','phone'=>'15938685541'];
//        $mg_id = Driver::select('phone')->where('phone', $formData['phone'])->limit(1)->get()->toArray();
//        if(!empty($mg_id[0])){
//            return  wei_jiami(500,['errorinfo'=>'该手机号已被注册']);
//        }
//        if(array_key_exists('password', $formData)){
//            $formData['password'] = bcrypt($formData['password']);
//        }
//        $dd = substr(strval(rand(10000,19999)),1,4);
//        $token1 = md5($dd);
//        $formData['token'] = $token1;
//        $z = Driver::create($formData);
//        if ($z) {
//            $shuju = ['errorinfo'=>'增加成功'];
//            return 1;
//        } else {
//            $shuju = ['errorinfo'=>'增加失败'];
//            return 0;
//        }
//        $search = ['phone' => '9541'];
//        $info = User::where(function($query) use($request,$search){
//            foreach ($search as $k => $v){
//                if (!empty($v)){
//                    $query->where($k,'like',"%$v%");
//                }
//            }
//        })->get();
//        $formData= ['region_name'=> '河南周口'];
//        $sjk = 'region';
//        $yz_ziduan =  only_yz($sjk);
//        $ziyuan = orm_sjk($sjk);
//        if($yz_ziduan){
//            foreach ($yz_ziduan as $k => $v){
////                return [$formData[$k],$v];
//                if(isset($formData[$k]) && !empty($formData[$k])){
//                    $cunzai_ziduan = $ziyuan->select($k)->where($k,$formData[$k])->get();
//                    if(count($cunzai_ziduan) !== 0){
//                        $shuju = ['errorinfo'=> $v];
//                        return wei_jiami(500,$shuju);
//                    }
//                }
//            }
//        }
//            foreach ($y_info as $kk => $vv){
//                $y_cewei = $vv->veh_type->cewei_num;
//                if($h_yuxia > $y_cewei){
//                    $data = [
//                        'order_id'=>$order_id,
//                        'car_id' => $v,
//                    ];
//                    OrderVeh::where('type_id',$vv->type_id)->update($data);;
//                }
//            $y_info = mul_sort($y_info,'veh_type','cewei_num');
//            foreach ($y_info as $k => $v){
//                $y_num += $v['veh_type']['cewei_num'];
//            }
//            return $y_num;
//            $data = [
//                [
//                    'id' => 13,
//                    'name' => 'Arthur Dent',
//                    'age'=>['cewei_num'=>1],
//                ],
//                [
//                    'id' => 22,
//                    'name' => 'Ford Prefect',
//                    'age'=>['cewei_num'=>6],
//                ],
//                [
//                    'id' => 5,
//                    'name' => 'Trillian Astra',
//                    'age'=>['cewei_num'=>4],
//                ],
//            ];
//            $data1 = [
//                [
//                    'sd' => 13,
//                    'name' => 'Arthur Dent',
//                    'age'=>['cewei_num'=>1],
//                ],
//                [
//                    'sd' => 22,
//                    'name' => 'Ford Prefect',
//                    'age'=>['cewei_num'=>6],
//                ],
//                [
//                    'sd' => 5,
//                    'name' => 'Trillian Astra',
//                    'age'=>['cewei_num'=>4],
//                ],
//            ];
//    foreach ($data as $k =>$v){
//
//            foreach ($data1 as $kk =>$vv){
//                if($vv['sd'] <21){
//                    unset($data1[$kk]);
//                    echo '2-'.$vv['sd'].'<br>';
//                }else{
//                    break;
//                }
//            }
//        echo '1-'.$v['id'].'<br>';
//    }

//            return  mul_sort($y_info,'veh_type','cewei_num');

//        $huo_num = 0;
//        $y_num = 0;
//        $order_id = 7;
//        $data['car_ids'] = [2,4];
//        if(isset($data['car_ids']) && !empty($data['car_ids'])){
//            $status = Car::select('state','yuxia_num')->whereIn('car_id',$data['car_ids'])->get();
//            foreach ($status as $k => $v){
//                if($v->state === '运输中' || $v->state === '停运'){
//                    $shuju = ['errorinfo'=>false];
//                    return wei_jiami('500',$shuju);
//                }else{
//                    $huo_num += $v->yuxia_num;
//                }
//            }
//            $y_info = OrderVeh::with('veh_type')->where('order_id',$order_id)->get(['type_id'])->toArray();
//            //三维数组从小到大排序
//            $y_info = mul_sort($y_info,'veh_type','cewei_num');
//            foreach ($y_info as $k => $v){
//                $y_num += $v['veh_type']['cewei_num'];
//            }
//
//            if($huo_num < $y_num) {
//                $shuju = ['errorinfo' => '货车单位不足成功','huo_num'=>$huo_num,'y_num'=>$y_num];
//                return wei_jiami(500, $shuju);
//            }else{
//                //增加关联表的数据
//                foreach ($data['car_ids'] as $k =>$v){
//                    $yuxia_num = Car::select('yuxia_num')->where('car_id',$v)->get();
//                    $h_yuxia = $yuxia_num[0]->yuxia_num;
//                    $yuxia_num = $h_yuxia;
//                    foreach ($y_info as $kk => $vv){
//                        $y_cewei = $vv['veh_type']['cewei_num'];
////                        return ['$h_yuxia'=>$h_yuxia,'$y_cewei'=>$y_cewei];
//                        //判断被运输是否小于单个货车车位
//                        if($h_yuxia > $y_cewei){
//                            //除去已分配好的车辆
//                            $h_yuxia = $yuxia_num -$y_cewei;
//                            $data_OrderVeh = [
//                                'car_id' => $v,
//                            ];
////                            return ['$v'=>$v,'type_id'=>$vv['type_id'],'type_id1'=>'45'];
//                            OrderVeh::where('type_id',$vv['type_id'])->update($data_OrderVeh);
//                            unset($y_info[$kk]);
//                        }else{
//                            //如果$y_info 未分配完 但是此货车 一装不下 更新 车位
//                            $data_car = [
//                                'yuxia_num' => $h_yuxia,
//                            ];
//                            Car::where('car_id',$v)->update($data_car);
//                            //给下一辆货车分配
//                            break;
//                        }
//                        echo '<pre>';
//                        print_r($y_info);
//                        echo '<br>';
//                        //如果$y_info 为空已分配完 更新 车位
//                        if(empty($y_info)){
//                            $data_car = [
//                                'yuxia_num' => $h_yuxia,
//                            ];
//                            Car::where('car_id',$v)->update($data_car);
//                            //给下一辆货车分配
//                            $shuju = ['success' => '货车分配成功'];
//                            return wei_jiami(200, $shuju);
//                        }
//                    }
//                }
//            }
//        }
//        $gai =  ['driver_id'=>null];

//        if (!empty($v)  && ($v != 'unde') && ($v != 'de')){
//            //新修改1 加上数组检索
//            if(is_array($v)){
//                $query->whereIn($k,$v);
//            }else{
////                            $v = '等待中1';
//                $query->where($k, $v);
//            }
//        }else if($v == 'unde'){
////                        $v = null;
//            $query->where($k, null);
//        }
//        $hel = new WcNotify();
////
//        $data = [
//            'first' => ['value'=>urlencode("订单通知"),'color'=>"#743A3A"],
//            'keyword1' => ['value'=>urlencode("你在后台有订单要处理")],
////            'keyword2' => ['value'=>urlencode("9999元")],
////            'keyword3' => ['value'=>urlencode("王玉龙")],
//            'remark' => ['value'=>urlencode(date('Y-m-d H:i:s',time()))]
//        ];
//       $dda = $hel->doSend('oWbEz1iSdXG_H78ZrGvRBvd9AfBE',
//           'iOCJhOwTL64EHbsm71oCFNtES7PfzpEAuJG1Atf3vmA','http://56.xizangyaxiangwuliu.com',$data);
//        $gai_id =  OrderVeh::whereIn('order_id',[7])->where('is_load','1')->get();
//        $car_wai = [
//            'order_ids'=>7,
//        ];
//        $zzz =  CarWai::where('wai_id',5)->update($car_wai);
        //  <a class="btn" href="http://t.cn/Evw9UNi">打开微信</a>
            return view('weixin');
    });


    //需要加密或验证的路由---------------------------------------------------------

            //是否可以这样  Route::group(['middleware'=> ['yanzheng','fanqiang']],function() {
        Route::group(['middleware'=>'yanzheng'],function() {
            Route::group(['middleware'=>'fanqiang'],function (){
                Route::group(['middleware'=>'AdminOperationLog'],function (){
                //订单管理
                Route::post( 'order/index','OrderController@index');
                Route::post('order/create','OrderController@create');
                Route::post('order/update','OrderController@update');
                Route::post('order/delete','OrderController@delete');
                Route::post('order/assign_car','OrderController@assign_car');

                Route::post( 'order/comment','OrderController@comment');
                Route::post( 'order/comment_create','OrderController@comment_create');
                Route::post( 'order/createCar','OrderController@createCar');
                Route::post('order/up_pic','OrderController@up_pic');
                //装车

                Route::post( 'order/update_process','OrderController@update_process');
                Route::post('order/load_car','OrderController@load_car');
                Route::post('order/unload_car','OrderController@unload_car');
                Route::post('order/send_car','OrderController@send_car');


                //用户登录系统
                Route::post('user/index', 'UserController@index');
                Route::post('user/create','UserController@create');
                Route::post('user/update','UserController@update');
                Route::post('user/delete','UserController@delete');


                //帮助协议
                Route::post('help/create','HelpController@create');
                Route::post('help/update','HelpController@update');
                Route::post('help/delete','HelpController@delete');

                //司机管理
                Route::post('driver/create','DriverController@create');
                Route::post('driver/update','DriverController@update');
                Route::post('driver/delete','DriverController@delete');
                Route::post('driver/index','DriverController@index');

                Route::post( 'permission/index','PermissionController@index');
                Route::post('permission/create','PermissionController@create');
                Route::post('permission/update','PermissionController@update');
                Route::post('permission/delete','PermissionController@delete');
                //管理员管理
                Route::post('manager/create','ManagerController@create');
                Route::post('manager/update','ManagerController@update');
                Route::post('manager/delete','ManagerController@delete');
                Route::post('manager/index','ManagerController@index');

                //地址管理
                Route::post('uadd/create','UaddController@create');
                Route::post('uadd/update','UaddController@update');
                Route::post('uadd/delete','UaddController@delete');
                Route::post( 'uadd/index','UaddController@index');

                //车辆类型管理
                Route::post('vehtype/create','VehTypeController@create');
                Route::post('vehtype/update','VehTypeController@update');
                Route::post('vehtype/delete','VehTypeController@delete');
                Route::post('vehtype/duo_create','VehTypeController@duo_create');

                //平台运输车辆管理
                Route::post('trucks/create','TrucksController@create');
                Route::post('trucks/update','TrucksController@update');
                Route::post('trucks/delete','TrucksController@delete');
                Route::post( 'trucks/index','TrucksController@index');


                //车辆管理
                Route::post('car/create','CarController@create');
                Route::post('car/update','CarController@update');
                Route::post('car/delete','CarController@delete');
                Route::post( 'car/index','CarController@index');
                Route::post( 'car/import','CarController@import');
                Route::get( 'car/export','CarController@export');
                Route::post( 'car/add_siji','CarController@add_siji');
                Route::post( 'car/cancel_siji','CarController@cancel_siji');

                //平台消息列表管理
                Route::post('msg/create','MsgController@create');
                Route::post('msg/pushmsg','MsgController@pushmsg');
                Route::post('msg/delete','MsgController@delete');
                Route::post('msg/index','MsgController@index');

                Route::post('msg/number','MsgController@number');
                Route::post('msg/status','MsgController@status');
                Route::post('msg/userid_index','MsgController@userid');
                //轮播图管理
                Route::post('banner/create','BannerController@create');
                Route::post('banner/update','BannerController@update');
                Route::post('banner/delete','BannerController@delete');

                Route::post('wbanner/create','WBannerController@create');
                Route::post('wbanner/update','WBannerController@update');
                Route::post('wbanner/delete','WBannerController@delete');
                //角色列表管理
                Route::post('role/create','RoleController@create');
                Route::post('role/update','RoleController@update');
                Route::post('role/delete','RoleController@delete');
                Route::post( 'role/index','RoleController@index');

                //帮助文章管理
                Route::post('protocol/create','ProtocolController@create');
                Route::post('protocol/update','ProtocolController@update');
                Route::post('protocol/delete','ProtocolController@delete');


                //运输区域管理
                Route::post('region/create','RegionController@create');
                Route::post('region/update','RegionController@update');
                Route::post('region/delete','RegionController@delete');


                //平台运输车辆管理
                Route::post('freight/create','FreightController@create');
                Route::post('freight/update','FreightController@update');
                Route::post('freight/delete','FreightController@delete');
                Route::post('freight/refresh','FreightController@refresh');
                //获取单一字段
                Route::post('field/create','FieldController@create');
                Route::post('field/update','FieldController@update');
                Route::post('field/delete','FieldController@delete');
                //上传
                Route::post('upload/upload_img','UploadController@upload_img');

                //测试
                Route::post( 'jia/mimi',function (Request $request){
                    $info = Region::get();
                    return $info;
                });
           });
        });
    });




//    //前台个人中心--课程列表展示(购买的、直播的)
//    Route::get('person/course','PersonController@course');
//
//    //前台个人中心--播放直播课程
//    Route::get('livecourse/play/{stream}','LivecourseController@play');

    });

