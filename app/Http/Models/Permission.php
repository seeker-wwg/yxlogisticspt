<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    protected $table = "permission"; //表名
    protected $primaryKey = "ps_id"; //主键名字
    protected $fillable = ['ps_name','ps_pid','ps_c',
        'ps_a','ps_route','ps_qd_route','ps_level'];//数据添加、修改时允许维护的字段

    //设置软删除
//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
