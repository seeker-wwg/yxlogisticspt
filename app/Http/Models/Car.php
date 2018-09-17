<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    protected $table = "car"; //表名
    protected $primaryKey = "car_id"; //主键名字
    protected $fillable = [
        'car_name', 'car_img', 'plate_num',
        'engine_num', 'frame_num', 'car_type',
        'driver_id', 'license_img','state',
        'unit_total_num','yuxia_num',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function driver()
    {
        return $this->hasOne('\App\Http\Models\Driver', 'driver_id', 'driver_id');
    }

    public function order()
    {
        return $this->hasOne('\App\Http\Models\Order', 'order_id', 'order_id');
    }
}
