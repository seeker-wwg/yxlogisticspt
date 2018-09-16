<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $table = "role"; //表名
    protected $primaryKey = "role_id"; //主键名字
    protected $fillable = ['role_name','ps_ids','ps_ca'];//数据添加、修改时允许维护的字段

    //设置软删除
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
