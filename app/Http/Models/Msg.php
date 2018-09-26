<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Msg extends Model
{
    protected $table = "msg"; //表名
    protected $primaryKey = "msg_id"; //主键名字
    protected $fillable = [
        'mg_id','title', 'content',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
//    public function user()
//    {
//        return $this->hasOne('\App\Http\Models\User', 'user_id', 'user_id');
//    }

    public function user(){
        /*
         * 第一个参数：要关联的表对应的类
         * 第二个参数：中间表的表名
         * 第三个参数：当前表跟中间表对应的外键
         * 第四个参数：要关联的表跟中间表对应的外键
         * */
        return $this->belongsToMany('\App\Http\Models\User','user_msg','msg_id','user_id');
    }

    public function driver(){
        /*
         * 第一个参数：要关联的表对应的类
         * 第二个参数：中间表的表名
         * 第三个参数：当前表跟中间表对应的外键
         * 第四个参数：要关联的表跟中间表对应的外键
         * */
        return $this->belongsToMany('\App\Http\Models\Driver','driver_msg','msg_id','driver_id');
    }


    public function manager(){
        /*
         * 第一个参数：要关联的表对应的类
         * 第二个参数：中间表的表名
         * 第三个参数：当前表跟中间表对应的外键
         * 第四个参数：要关联的表跟中间表对应的外键
         * */
        return $this->hasOne('\App\Http\Models\Manager','msg_id','mg_id');
    }
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
