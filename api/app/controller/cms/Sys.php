<?php


namespace app\controller\cms;


use app\model\from_key;
use app\model\sys_config;
use think\facade\Cache;

class Sys
{
    public function get($type=''){
        return sys_config::getinfo($type);
    }

    public function update(){
        return sys_config::editinfo();
    }

    public function getkey(){
        return app('json')->go(sys_config::getkey2());

    }

    public function edkey(){
        return app('json')->go(sys_config::edkey2());
    }
<<<<<<< HEAD
=======

    public function getAllSysteam2(){

        $re=SysteamModel::select();
        $a=$b=[];
        foreach ($re as $item){
            array_push($a,$item['key']);
            array_push($b,$item['value']);
        }
        $c=array_combine($a,$b);
        foreach ($re as $item){
            array_push($c,$item['desc']);

        }




        return app('json')->go($c);


    }
>>>>>>> 07ebe3a393960bcd3e22c0168f962d4ead28f67f
}