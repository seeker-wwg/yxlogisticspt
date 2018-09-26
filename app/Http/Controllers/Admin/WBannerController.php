<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\WBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class WBannerController extends Controller
{

    /**
     * 附件上传处理--上传课时封面图
     * @param Request $request
     */
//    public function up_pic(Request $request)
//    {
//        $file = $request->file('Filedata');
//        if($file->isValid()){
//            //附件上传
//            //$file->store(附件存储的二级目录,磁盘驱动);
//            $rst = $file->store('banner','public');
//            //echo $rst;// video/87dvr2nPyJZgcwIALQzlXAvDJc3CisHGgYOkdObO.png
//            //echo "/storage/".$rst;// /storage/video/87dvr2nPyJZgcwIALQzlXAvDJc3CisHGgYOkdObO.png
//            echo json_encode(serialize(['status'=>200,'filename'=>"/storage/".$rst]));
//        }else{
//            echo json_encode(serialize(['status'=>500,'banner'=>'上传失败']));
//        }
//        exit;
//    }
    
    /**
     * 轮播图列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return shousuo($request);
        }
    }




    /**
     * 删除轮播图信息
     * @param Request $request
     * @param Banner $Banner
     * @return array
     * @throws \Exception
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return zengjia($request);
        }
    }


    /**
     * 修改轮播图
     * @param Request $request
     * @param Price $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo =re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $formData = $info['formData'];

            WBanner::truncate();
            foreach ($formData as $k =>$v){
                $z  =  WBanner::create($v);
            }
            if ($z) {
                $shuju = ['errorinfo'=>'修改成功'];
                return re_jiami(200,$shuju,$token);
            } else {
                $shuju = ['errorinfo'=>'修改失败'];
                return re_jiami(500,$shuju,$token);
            }
        }
    }


    /**
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        if($request -> isMethod('post')){
            return shanchu($request);
        }
    }
}
