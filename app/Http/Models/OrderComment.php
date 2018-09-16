<?php

namespace App\Http\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderComment extends Model
{
    protected $table = "order_comment"; //表名
    protected $primaryKey = "order_comment_id"; //主键名字
    protected $fillable = [
        'order_id','content', 'score', 'imgs',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段

//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
