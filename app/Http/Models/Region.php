<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    protected $table = "region"; //表名
    protected $primaryKey = "region_id"; //主键名字
    protected $fillable = [
        'longitude',
        'latitude',
        'region_name','region_add',
        'province',
        'city',
        'area',
        'region_type','carry_out_cost','give_spot','take_spot',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段

//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
