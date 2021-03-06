<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    protected $table = "banner"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'img_url',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
//    public function user()
//    {
//        return $this->hasOne('\App\Http\Models\User', 'user_id', 'user_id');
//    }
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
