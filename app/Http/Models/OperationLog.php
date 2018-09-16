<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationLog extends Model
{
    protected $table = "operation_log"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = ['uid','identity','name',
        'path_name','path','method'
        ,'ip','created_at'
        ,'updated_at','deleted_at'
    ];//数据添加、修改时允许维护的字段

    //设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
