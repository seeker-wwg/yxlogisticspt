<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    protected $table = "field"; //表名
    protected $primaryKey = "field_id"; //主键名字
    protected $fillable = [
        'about', 'phone', 'company','email','fax','userProtocol','carProtocol','give_up_Protocol','logo_url','address','qq',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
//    public function stream()
//    {
//        return $this->hasOne('\App\Http\Models\Stream', 'stream_id', 'stream_id');
//    }
}
