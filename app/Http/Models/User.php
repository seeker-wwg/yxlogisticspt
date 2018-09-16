<?php

namespace App\Http\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    protected $table = "user"; //表名
    protected $primaryKey = "user_id"; //主键名字
    protected $fillable = [
        'user_name','user_sex','user_age',
        'port_type','port_no','phone','email','password','title_image','code','id_status','wechat','operation','token','token_time','created_at',
        'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    //设置软删除
    public  function setFillable($arr){
        $this->fillable = $arr;
    }
    public function uadd()
    {
        return $this->hasMany('\App\Http\Models\Uadd','user_id');
    }
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
//    protected $hidden = [
//        'password', 'token',
//    ];
}
