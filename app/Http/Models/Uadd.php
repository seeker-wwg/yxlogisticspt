<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uadd extends Model
{
    protected $table = "uadd"; //表名
    protected $primaryKey = "uadd_id"; //主键名字
    protected $fillable = ['user_id','user_add',
        'd_add',
        'name',
        'phone',
        'longtitude',
        'latitude',
        'created_at',
        'updated_at','deleted_at'];//数据添加、修改时允许维护的字段

    public function user()
    {
        return $this->belongsTo('\App\Http\Models\User','user_id');
    }
    //设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
