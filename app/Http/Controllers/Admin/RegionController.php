<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class RegionController extends Controller
{

    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {

        if ($request->isMethod("post")) {

            $datainfo = $request->input('data');
            $offset = isset($datainfo['start'])?$datainfo['start']:null;
            $len = isset($datainfo['length'])?$datainfo['length']:null;
            $field = isset($datainfo['field'])?$datainfo['field']:null;
            $connect = isset($datainfo['connect'])?$datainfo['connect']:null;
            $population = isset($datainfo['population'])?$datainfo['population']:null;

            $region_id =  isset($datainfo['region_id'])?$datainfo['region_id']:null;
            $take_spot = isset($datainfo['take_spot'])?$datainfo['take_spot']:null;
            $give_spot = isset($datainfo['give_spot'])?$datainfo['give_spot']:null;
            $wechat = isset($datainfo['wechat'])?$datainfo['wechat']:null;
            $operation = isset($datainfo['operation'])?$datainfo['operation']:null;
            $created_at =isset($datainfo['created_at'])?$datainfo['created_at']:null;
            $duan = isset($datainfo['duan'])?$datainfo['duan']:null;//获得排序的字段
            $xu = isset($datainfo['xu'])?$datainfo['xu']:null;//获得排序的字段

//            return [$duan,$field,$give_spot];
//            A. 数据分页(显示条数)

//            $offset = 0;
//            $len = 3;
            //B. 排序(如果为空则 id  倒序)
            if (!isset($duan) || empty($duan) ){
                $duan = 'region_id';
//              $xu = $request->input('desc');  //排序的顺序asc/desc

            }
            if(!isset($xu) || empty($xu)){
                $xu = 'desc';
            }

            //C. 模糊检索(课时名称 和 课时描述)
//            $search = $request->input('search');//获得检索的条件值
            $search ='';
            if(!is_null($offset) && !empty($len)){
                $shuju = Region::offset($offset)
                    ->limit($len)
                    ->orderBy($duan, $xu)
                    ->where(function ($query) use($request,$region_id){
                        if (!empty($region_id)){
                            $query->where('region_id', 'like', "%$region_id%");
                        }
                    })
                    ->where(function ($query) use($request,$give_spot){
                        if (isset($give_spot) ){
                            $query->where('give_spot', $give_spot);
                        }
                    })
                    ->where(function ($query) use($request,$take_spot){
                        if (isset($take_spot)){
                            $query->where('take_spot', $take_spot);
                        }
                    })
                    ->where(function ($query) use($request,$wechat,$operation,$created_at){
                        if (!empty($wechat) && !empty($operation) && !empty($created_at)){
                            $query->where('wechat', $wechat)
                                ->where('operation', $operation)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && !empty($operation)){
                            $query->where('wechat', $wechat)
                                ->where('operation', $operation);
                        }elseif (!empty($operation) && !empty($created_at)){
                            $query->where('operation', $operation)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && !empty($created_at)){
                            $query->where('wechat', $wechat)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && empty($operation) && empty($created_at)){
                            $query->where('wechat', $wechat);
                        }elseif (empty($wechat) && !empty($operation) && empty($created_at)){
                            $query->where('operation', $operation);
                        }elseif (empty($wechat) && empty($operation) && !empty($created_at)){
                            $query->whereBetween('created_at',$created_at);
                        }
                    })
                    ->get($field); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
            }else{
                $shuju = Region::orderBy($duan, $xu)
              
                    ->where(function ($query) use($request,$region_id){
                        if (!empty($region_id)){
                            $query->where('region_id', 'like', "%$region_id%");
                        }
                    })
                    ->where(function ($query) use($request,$give_spot){
                        if (isset($give_spot)){
                            $query->where('give_spot', $give_spot);
                        }
                    })
                    ->where(function ($query) use($request,$take_spot){
                        if (isset($take_spot)){
                            $query->where('take_spot', $take_spot);
                        }
                    })
                    ->where(function ($query) use($request,$wechat,$operation,$created_at){
                        if (!empty($wechat) && !empty($operation) && !empty($created_at)){
                            $query->where('wechat', $wechat)
                                ->where('operation', $operation)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && !empty($operation)){
                            $query->where('wechat', $wechat)
                                ->where('operation', $operation);
                        }elseif (!empty($operation) && !empty($created_at)){
                            $query->where('operation', $operation)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && !empty($created_at)){
                            $query->where('wechat', $wechat)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!empty($wechat) && empty($operation) && empty($created_at)){
                            $query->where('wechat', $wechat);
                        }elseif (empty($wechat) && !empty($operation) && empty($created_at)){
                            $query->where('operation', $operation);
                        }elseif (empty($wechat) && empty($operation) && !empty($created_at)){
                            $query->whereBetween('created_at',$created_at);
                        }
                    })
                    ->get($field); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
            }


            return wei_jiami(200,$shuju);
        }
    }

    /**
     * 修改培养信息
     * @param Request $request
     * @param Region $User
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

    /**
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')){
            return zengjia($request);
        }
    }
}
