<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Freight;
use App\Http\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FreightController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod("post")) {
            return shousuo($request);
        }
    }


    /**
     * 用户列表
     * @param Request $request
     */
    public function refresh(Request $request)
    {
        if ($request->isMethod("post")) {
            //设置两个标志
            $datainfo = re_jiemi($request);
            $token = $datainfo[1];
            $give_info = Region::where('give_spot', '1')->get(['region_id','region_name','province','city','area','give_spot','take_spot','longitude','latitude']);
            $take_info = Region::where('take_spot', '1')->get(['region_id','region_name','province','city','area','give_spot','take_spot','longitude','latitude']);
            //刷新组成新数组
            $new_sz = [];
            $i = 0;//记录数量
            //车型
            $type_size = ['微型车','小型车','紧凑型车','中型车','中大型车','豪华车'];
            $reight_info = Freight::get()->toArray();//带刷新的
                foreach ($give_info as $k => $v){
                    $start_name =$v->province.'/'.$v->city.'/'.$v->area.'/'.$v->region_name;
                    foreach ($take_info as $kk => $vv){
                        $end_name =$vv->province.'/'.$vv->city.'/'.$vv->area.'/'.$vv->region_name;
                        if( $v->region_name != $vv->region_name ){
                            foreach ($type_size as $kkk =>$vvv){
                                $new_sz[$i]['start_id'] = $v->region_id;
                                $new_sz[$i]['end_id'] = $vv->region_id;

                                $new_sz[$i]['start_longitude'] = $v->longitude;
                                $new_sz[$i]['start_latitude'] = $v->latitude;

                                $new_sz[$i]['end_longitude'] = $vv->longitude;
                                $new_sz[$i]['end_latitude'] = $vv->latitude;

                                $new_sz[$i]['start_name'] = $start_name;
                                $new_sz[$i]['end_name'] = $end_name;
                                $new_sz[$i]['type_size'] = $vvv;
                                $i = $i +1;
                            }
                        }
                    }
                }

                //去除或增加数据库已存在

            if(count($new_sz) > count($reight_info)){
                foreach ($new_sz as $k => $v){
                    if(!empty($reight_info)){

                        foreach ($reight_info as $kk =>$vv){

                            if(($v->start_id == $vv->start_id) &&($v->end_id == $vv->end_id) && ($v->type_size == $vv->type_size)){
                                unset($new_sz[$k]);
                            }
                        }
                    }
                }
                foreach ($new_sz as $k => $v){
                    Freight::create($v);
                }
                $shuju = ['errorinfo'=>'刷新成功'];
                return re_jiami(200,$shuju,$token);
            }else{
                foreach ($new_sz as $k => $v){
                    if(!empty($reight_info)){
                        foreach ($reight_info as $kk =>$vv){
                            if(($v->start_id == $vv->start_id) &&($v->end_id == $vv->end_id) && ($v->type_size == $vv->type_size)){
                                unset($reight_info[$kk]);
                            }
                        }
                    }
                }
                foreach ($reight_info as $k => $v){
                    Freight::where('freight_id',$v->freight_id)->delete();
                }
                $shuju = ['errorinfo'=>'刷新成功'];
                return re_jiami(200,$shuju,$token);
            }
        }
    }


    /**
     * 添加信息
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
          return zengjia($request);
        }
    }


    /**
     * 修改培养信息
     * @param Request $request
     * @param Freight $User
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
