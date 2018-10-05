<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderVeh extends Model
{
    protected $table = "order_veh"; //表名
    protected $primaryKey = "order_veh_id"; //主键名字
    protected $fillable = [
        'order_id','type_id','car_id','is_load','type_name','veh_price','plate_number',
        'veh_img','veh_video',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function order()
    {
        return $this->hasOne('\App\Http\Models\Order', 'order_id', 'order_id');
    }

    public function car()
    {
        return $this->hasOne('\App\Http\Models\Car', 'car_id', 'car_id');
    }

//    public function veh_type()
//    {
//        return $this->hasOne('\App\Http\Models\Vehicle', 'veh_id', 'veh_id');
//    }

    public function veh_type()
    {
        return $this->hasOne('\App\Http\Models\VehType', 'type_id', 'type_id');
    }
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
