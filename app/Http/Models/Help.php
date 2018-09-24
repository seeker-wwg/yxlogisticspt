<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $table = "hlep"; //表名
    protected $primaryKey = "hlep_id"; //主键名字
    protected $fillable = [
        'title','content','mg_id',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function manager()
    {
        return $this->hasOne('\App\Http\Models\Manager', 'mg_id', 'mg_id');
    }
}
