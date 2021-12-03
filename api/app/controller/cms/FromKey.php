<?php


namespace app\controller\cms;


use app\model\excle;
use app\model\from_key;
use app\model\order;


class FromKey
{
    public function get(){
        return from_key::get();
    }

    public function add(){
        return from_key::add();
    }

    public function del(){
        return from_key::remove();
    }

    public function edit(){
        return from_key::edit();
    }

    public function addall(){  //批量新增 带覆盖
        $re=request()->post();
       //  excle::dd('old','../xl/');                       //先创建一份之前预约数据的一次备份

        from_key::deleteall();  //清除之前的key

        //同时修改order表之前的数据
       $res=order::where('is_new=1')->select();
       foreach ($res as $i){
           $i['is_new']=0;
            $i->save();
       }

        $i = 0;
        foreach ($re as $s) {        //存储时以列名做为标识key
            $data = [
                'keyname' => excle::getnum($i),
                'name' => $s['name'],
                'type'=>$s['type'],
                'msg'=>$s['msg'],
                'is_ok'=>$s['is_ok'],
                'is_se'=>$s['is_se'],
                'is_view'=>$s['is_view'],
            ];
            from_key::create($data);
            $i++;
        }
        return app('json')->go(['msg'=>'新增数据'.$i.'条']);
    }


    public function delall(){
        $f=new from_key();
        $f->deleteall();   //也会清除目前的预约信息并保存
        return app('json')->go(['msg'=>'已删除全部数据']);
    }
}