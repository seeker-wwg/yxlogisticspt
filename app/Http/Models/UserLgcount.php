<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLgcount extends Model
{
    protected $table = "user_lgcount"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
       'phone', 'count',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
