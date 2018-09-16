<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $table = "article"; //表名
    protected $primaryKey = "article_id"; //主键名字
    protected $fillable = [
        'title','keywords', 'content', 'status','manager_id',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    public function manager()
    {
        return $this->hasOne('\App\Http\Models\Manager', 'manager_id', 'manager_id');
    }
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
