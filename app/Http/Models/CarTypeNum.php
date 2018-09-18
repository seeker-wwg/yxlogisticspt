<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarTypeNum extends Model
{
    protected $table = "car_type_num"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'car_type', 'unit_total_num',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
//    public function user()
//    {
//        return $this->hasOne('\App\Http\Models\User', 'user_id', 'user_id');
//    }
}
