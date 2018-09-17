<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarWai extends Model
{
    protected $table = "car_wai"; //表名
    protected $primaryKey = "wai_id"; //主键名字
    protected $fillable = [
        'car_id', 'longitude',
        'latitude', 'mg_id',
        'longitude', 'address_name',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function car()
    {
        return $this->hasOne('\App\Http\Models\Car', 'car_id', 'car_id');
    }
}
