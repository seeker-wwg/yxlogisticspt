<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderWai extends Model
{
    protected $table = "order_wai"; //表名
    protected $primaryKey = "wai_id"; //主键名字
    protected $fillable = [
        'order_id', 'status_updata',
        'status_updata_time',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function order()
    {
        return $this->hasOne('\App\Http\Models\Order', 'order_id', 'order_id');
    }

    public function manager()
    {
        return $this->hasOne('\App\Http\Models\Manager', 'mg_id', 'mg_id');
    }
}
