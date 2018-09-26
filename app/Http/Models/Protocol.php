<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Protocol extends Model
{
    protected $table = "protocol"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = [
        'title','key', 'content', 'mg_id',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function manager()
    {
        return $this->hasOne('\App\Http\Models\Manager', 'mg_id', 'mg_id');
    }
}
