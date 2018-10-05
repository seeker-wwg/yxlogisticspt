<?php

namespace App\Http\models;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $table = "order"; //表名
    protected $primaryKey = "order_id"; //主键名字
    protected $fillable = [
        'order_sn','d_trade_sn','w_trade_sn', 'sender_name', 'sender_type','sender_start_point',
        'sender_pointer_longtitude','sender_pointer_latitude','sender_pointer_add',
        'sender_add',
        'sender_door_cost',
        'sender_longitude','sender_latitude',
        'sender_detail_add',
        'sender_phone','receive_name', 'receive_type','receive_start_point',
        'receive_pointer_longtitude','receive_pointer_latitude','sender_pointer_add',
        'receive_add',
        'receive_door_cost',
        'receive_longitude','receive_latitude',
        'receive_detail_add','receive_phone',
        'user_id', 'dingjin_payment_method','weikuang_payment_method','reserve_price', 'stay_price','total_price',
        'pay_reserve_time', 'pay_time', 'process','pay_status','order_comm_status',
        'not_pass','baoe_cost','baofei_cost',
        'created_at', 'updated_at', 'deleted_at'
    ];//数据添加、修改时允许维护的字段

    public function user()
    {
        return $this->hasOne('\App\Http\Models\User', 'user_id', 'user_id');
    }
    public function order_veh()
    {
        return $this->hasMany('\App\Http\Models\OrderVeh', 'order_id');
    }
    public function order_wai()
    {
        return $this->hasMany('\App\Http\Models\OrderWai','order_id');
    }

//    public function car()
//    {
//        return $this->hasMany('\App\Http\Models\Car','order_id');
//    }

    /**
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
//    public function car(){
//        /*
//         * 第一个参数：要关联的表对应的类
//         * 第二个参数：中间表的表名
//         * 第三个参数：当前表跟中间表对应的外键
//         * 第四个参数：要关联的表跟中间表对应的外键
//         * */
//        return $this->belongsToMany('\App\Http\Models\Car','order_car','order_id','car_id');
//    }

//    use SoftDeletes;
//    protected $dates = ['deleted_at'];
}
