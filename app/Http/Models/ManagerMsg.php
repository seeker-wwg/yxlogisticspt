<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManagerMsg extends Model
{
    protected $table = "manager_msg"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'mg_id', 'msg_id','status',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function manager()
    {
        return $this->hasOne('\App\Http\Models\Manager', 'mg_id', 'mg_id');
    }
    public function msg()
    {
        return $this->hasOne('\App\Http\Models\Msg', 'msg_id', 'msg_id');
    }
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
