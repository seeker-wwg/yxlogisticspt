<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    protected $table = "price"; //表名
    protected $primaryKey = "price_id"; //主键名字
    protected $fillable = [
        'region_id','type','price',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function region()
    {
        return $this->hasOne('\App\Http\Models\Region', 'region_id', 'region_id');
    }
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
