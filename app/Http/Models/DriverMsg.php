<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverMsg extends Model
{
    protected $table = "driver_msg"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'driver_id', 'msg_id','status',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function driver()
    {
        return $this->hasOne('\App\Http\Models\Driver', 'driver_id', 'driver_id');
    }
    public function msg()
    {
        return $this->hasOne('\App\Http\Models\Msg', 'msg_id', 'msg_id');
    }
}
