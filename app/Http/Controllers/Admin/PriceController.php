<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {

//        $info = Price::where('mg_id','>',1)->with('role')->paginate(6);
//        dd($info);
        $cnt = Price::count();
        if ($request->isMethod("post")) {
            $price_id = $request->input('price_id');
            $type = $request->input('type');
            $region_id = $request->input('region_id');
            $created_at = $request->input('created_at');
//            $type = '否';

//            A. 数据分页(显示条数)
            $offset = $request->input('start');
            $len = $request->input('length');
//            $offset = 0;
//            $len = 3;
            //B. 排序(如果为空则 id  倒序)
            $duan = $request->input('duan');//获得排序的字段
            if (empty($duan)){
                $duan = 'price_id';
//              $xu = $request->input('desc');  //排序的顺序asc/desc
                $xu = 'desc';
            }else{

                $xu = 'desc';  //排序的顺序asc/desc
            }


            //C. 模糊检索(课时名称 和 课时描述)
//            $search = $request->input('search');//获得检索的条件值
            $search ='';
            if(!is_null($offset) && !empty($len)){
                $shuju = Price::select()->offset($offset)
                    ->limit($len)
                    ->orderBy($duan, $xu)
                ->with('region')
                    ->where(function ($query) use($request,$price_id){
                        if (!empty($price_id)){
                            $query->where('price_id', 'like', "%$price_id%");
                        }
                    })
                    ->where(function ($query) use($request,$type,$region_id,$created_at){
                        if (!is_null($type) && !empty($region_id) && !empty($created_at)){
                            $query->where('type', $type)
                                ->where('region_id', $region_id)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && !empty($region_id)){
                            $query->where('type', $type)
                                ->where('region_id', $region_id);
                        }elseif (!empty($region_id) && !empty($created_at)){
                            $query->where('region_id', $region_id)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && !empty($created_at)){
                            $query->where('type', $type)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && empty($region_id) && empty($created_at)){
                            $query->where('type', $type);
                        }elseif (is_null($type) && !empty($region_id) && empty($created_at)){
                            $query->where('region_id', $region_id);
                        }elseif (is_null($type) && empty($region_id) && !empty($created_at)){
                            $query->whereBetween('created_at',$created_at);
                        }
                    })
                    ->get(); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
            }else{
                $shuju = Price::select()
                    ->orderBy($duan, $xu)
                    ->with('region')
                    ->where(function ($query) use($request,$price_id){
                        if (!empty($price_id)){
                            $query->where('price_id', 'like', "%$price_id%");
                        }
                    })
                    ->where(function ($query) use($request,$type,$region_id,$created_at){
                        if (!is_null($type) && !empty($region_id) && !empty($created_at)){
                            $query->where('type', $type)
                                ->where('region_id', $region_id)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && !empty($region_id)){
                            $query->where('type', $type)
                                ->where('region_id', $region_id);
                        }elseif (!empty($region_id) && !empty($created_at)){
                            $query->where('region_id', $region_id)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && !empty($created_at)){
                            $query->where('type', $type)
                                ->whereBetween('created_at',$created_at);
                        }elseif (!is_null($type) && empty($region_id) && empty($created_at)){
                            $query->where('type', $type);
                        }elseif (is_null($type) && !empty($region_id) && empty($created_at)){
                            $query->where('region_id', $region_id);
                        }elseif (is_null($type) && empty($region_id) && !empty($created_at)){
                            $query->whereBetween('created_at',$created_at);
                        }
                    })
                    ->get(); //数据本身是一个集合，里边每个单元都是一个小的lesson对象
            }


            $info = encrypt_pass(serialize([
                'status' => 200,
                'recordsTotal' => $cnt,
                'data' => $shuju,
            ]),cut_token(session('_token')));
            return $shuju;
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
            $formData = $request->input('formData');
            Price::create($formData);
            return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
        }else {
            return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'新增失败']),cut_token(session('_token')));
        }
    }


    /**
     * 修改培养信息
     * @param Request $request
     * @param Price $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $price_id = $request->input('price_id');
            $formData = $request->input('formData');
            Price::where('price_id',$price_id)->update($formData);
            return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));

        }else {
            return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'修改失败']),cut_token(session('_token')));
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
            $price_ids = $request->input('price_ids');
            $z = DB::table('price')->whereIn('price_id',$price_ids)->delete();
            if ($z) {
                return encrypt_pass(serialize(['status' => 200]),cut_token(session('_token')));
            } else {
                return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'删除失败']),cut_token(session('_token')));
            }
        }

    }
}
