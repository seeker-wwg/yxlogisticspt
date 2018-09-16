<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehType extends Model
{
    protected $table = "veh_type"; //表名
    protected $primaryKey = "type_id"; //主键名字
    protected $fillable = [
        'type_name','type_pid','type_level',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
