<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;
class UploadController extends Controller
{
/**
* 上传文件到七牛
* @author 高伟
* @date   2016-11-09T16:58:37+0800
* @param  Request                  $request [description]
* @return [type]                            [description]
*/


    public function upload_img(Request $request)
    {
        if ($request->isMethod('post')) {
            $datainfo = re_jiemi($request);
            $token = $datainfo[1];
            // 判断是否有文件上传
//            if ($request->hasFile('file')) {
                // 获取文件,file对应的是前端表单上传input的name
//                $file = $request->file('file');
                // Laravel5.3中多了一个写法
                // $file = $request->file;

                // 初始化
                $disk = QiniuStorage::disk('qiniu');
                $shuju = ['upload_token'=>$disk->uploadToken()];
                return re_jiami(200,$shuju,$token);
//                // 重命名文件
//                $fileName = md5($file->getClientOriginalName().time().rand()).'.'.$file->getClientOriginalExtension();
//
//                // 上传到七牛
//                $bool = $disk->put('banner/image_'.$fileName,file_get_contents($file->getRealPath()));
//                // 判断是否上传成功
//                if ($bool) {
//                    $path = $disk->downloadUrl('banner/image_'.$fileName);
////                    return '上传成功，图片url:'.$path;
//                    $path = substr($path,7);
//                    return  encrypt_pass(serialize(['status' =>200,"url"=>$path]),cut_token(session('_token')));
//                }
//                return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'上传失败']),cut_token(session('_token')));
//            }
//            return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'没有文件上传']),cut_token(session('_token')));
//            }
        }
//        return view('uploadFile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     * upload_car_execel
     */

public function upload_car_execel(Request $request)
{
    if ($request->isMethod('post')){
        // 判断是否有文件上传
        if ($request->hasFile('file')) {
            // 获取文件,file对应的是前端表单上传input的name
            $file = $request->file('file');
            $rst = $file->store('car', 'public');
            // 初始化
            $disk = QiniuStorage::disk('qiniu');
            // 重命名文件
            $fileName = md5($file->getClientOriginalName().time().rand()).'.'.$file->getClientOriginalExtension();

            // 上传到七牛
            $bool = $disk->put('car/execel_'.$fileName,file_get_contents($file->getRealPath()));
            // 判断是否上传成功
            if ($bool) {
//                $path = $disk->downloadUrl('car/execel_'.$fileName);
////                    return '上传成功，图片url:'.$path;
//                $path = substr($path,7);
        
                return  encrypt_pass(serialize(['status' =>200,'filename' => "storage/" . $rst]),cut_token(session('_token')));
            }
            return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'上传失败']),cut_token(session('_token')));
        }
        return encrypt_pass(serialize(['status' =>500,'errorinfo'=>'没有文件上传']),cut_token(session('_token')));
    }
    return view('uploadFile');
}
}