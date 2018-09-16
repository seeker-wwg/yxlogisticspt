<?php

namespace App\Http\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Authenticatable
{
    protected $table = "driver"; //表名
    protected $primaryKey = "driver_id"; //主键名字
    protected $fillable = [
        'driver_id','driver_name','driver_name','driver_sex','driver_age',
        'port_type','port_no','phone','email','password','title_image','code','id_status','wechat','operation','get_msg','token','token_time',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    //设置软删除
}
