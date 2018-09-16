<?php

namespace App\Tools;

use Illuminate\Support\Facades\Session;
/***
购物车类
实现对购物车里边课程的添加、删除操作

购物车信息转化为二维数组的效果如下：
array(
运车id1=>array('veh_id'=>'运车id','veh_count=>数量','veh_protection_price'=>'保价','veh_price'=>'运费'),
运车id2=>array('veh_id'=>'运车id','veh_count=>数量','veh_protection_price'=>'保价','veh_price'=>'运费'),
运车id3=>array('veh_id'=>'运车id','veh_count=>数量','veh_protection_price'=>'保价','veh_price'=>'运费'),
....
)
 */

class Cart{

    //购物车的一个属性，用于存放课程信息的
    private $cartInfo = array();

    function __construct(){
        $this -> loadData();
    }

    /***
    取得购物车里边已经存放的课程信息
    该方法是该类里边第一个被执行的方法
    在类的构造函数里边调用
     */
    function loadData(){
        if(Session::has('cart')){
            //获取购物车课程信息，并赋予给cartInfo成员属性
            $this->cartInfo = Session::get('cart');  //Array数组
        }
    }

    /***
    将课程添加到购物车里边
    @param $course = array('veh_id'=>'课程id','course_name'=>'名称','course_price'=>'单价')
     * 可能是个二维数组
     */
    function add($course){
//        $veh_id = $course['veh_id'];
//        //对重复购买的课程要判断(还要判断当前的购物车是否为空，即是否是第一次添加课程)
//        if(!empty($this->cartInfo) && array_key_exists($veh_id, $this->cartInfo)){
//            exit('课程不能重复购买！');
//        } else {
            $this -> cartInfo = $course;
//        }

        $this -> saveData();//将刷新的数据重新存入session
    }

    /***
    删除购物车里边指定的课程
    @param $veh_id 被删除课程的id信息
     */
    function del($veh_id){
        if(array_key_exists($veh_id, $this -> cartInfo)){
            unset($this -> cartInfo[$veh_id]);
        }
        $this -> saveData();//将刷新的数据重新存入session
    }

    /***
    清空购物车
     */
    function delall(){
        unset($this->cartInfo);
        $this -> saveData();//将刷新的数据重新存入session
    }


    /***
     * 获得购物车的课程总数量和总价格
     */
    function getNumberPrice(){

        $price = 0;//课程总价钱
        $price_yun = 0;//课程总价钱
        foreach($this->cartInfo as $_k => $_v){
            $price += $_v['veh_protection_price'];
            $price_yun += $_v['veh_price'];
        }

        $total_price = $price + $price_yun;

        return $total_price;
    }

    //返回购物车的课程信息，Array格式返回
    function getCartInfo(){
        return $this -> cartInfo;
    }

    /***
    将cartInfo数组的课程信息存入购物车
     */
    function saveData(){
        if(!empty($this->cartInfo)){
            Session::put('cart',$this->cartInfo);  //非空购物车
        }else{
            Session::put('cart','');    //空购物车
        }
    }
}


