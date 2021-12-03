<?php


namespace app\controller\user;


use app\controller\cms\Sys;
use ruhua\exceptions\BaseException;
use app\model\from_key;
use app\model\order_post;
use app\model\order as ordermodel;
use app\model\sys_config;
use think\Db;

class Order
{
    public function add(){
        return ordermodel::addorder();
    }

    public function cout(){
        return order_post::cout();
    }


    public function selectmine(){
        $re=request()->param();
        $q1=order_post::arrfind($re);
        if($q1){
            $q1['json']=json_decode($q1['json']);
            $q1['time']=date('Y-m-d H:i:s',$q1['time']);
        }
        else{
            throw new \ruhua\exceptions\BaseException(['msg'=>'未能查询到数据']);
        }
        return app('json')->go($q1);
    }

    public function getdate(){
        $date=ordermodel::getdate();  //日期获取
        return app('json')->go($date);
    }



    //cms
    public function get(){

        return ordermodel::getorder();
    }

    public function off(){   //开关预约
        return ordermodel::off();
    }

    public function close(){
        $post=input('post.');
        $id=$post['id'];
        if(!ordermodel::find($id)){
            throw new BaseException(['msg'=>'该预约信息不存在或已取消']);
        }
        ordermodel::find($id)->delete();
        return app('json')->go(['msg'=>'本次预约已取消']);
    }
    public function closeall(){

        if(ordermodel::deleteall()){
            return app('json')->go(['msg'=>'已清空当前预约数据']);
        }
        throw new BaseException(['msg'=>'清除失败或不完全']);
    }

    public function update(){  //更新预约，如果预约时间段小于当前时间段代表本次预约已经完成，无论该用户有没有去，此处作为一个刷新数据按钮
        $time = time();
        $q=\think\facade\Db::table('order')->where('time','<',$time)->update(['is_ok'=>0]);
        return app('json')->go(['msg'=>'更新完成','n'=>$q]);
    }


}