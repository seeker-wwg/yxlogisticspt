<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMsg extends Model
{
    protected $table = "user_msg"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'who','who_id', 'msg_id','status',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function user()
    {
        return $this->hasOne('\App\Http\Models\User', 'user_id', 'user_id');
    }
    public function msg()
    {
        return $this->hasOne('\App\Http\Models\Msg', 'msg_id', 'msg_id');
    }
}
