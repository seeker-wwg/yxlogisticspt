<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freight extends Model
{
    protected $table = "freight"; //表名
    protected $primaryKey = "freight_id"; //主键名字
    protected $fillable = [
        'start_id','end_id', 'type_id','per_cost','kilometre_count','freight_cost',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function vehtype()
    {
        return $this->hasOne('\App\Http\Models\VehType', 'type_id', 'type_id');
    }
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
