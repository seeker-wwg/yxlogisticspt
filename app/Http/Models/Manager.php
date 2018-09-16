<?php

namespace App\Http\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Authenticatable
{
    protected $table = "manager"; //表名
    protected $primaryKey = "mg_id"; //主键名字
    protected $fillable = [
        'mg_name','mg_name','mg_sex','mg_age','role_id',
        'phone','email','password','title_image','operation','token','token_time',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段
    //设置软删除


    /**
     * 建立与Role模型的关系
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this -> hasOne('App\Http\Models\Role','role_id','role_id');
    }
}
