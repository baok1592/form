<?php


namespace app\model;


use think\facade\Cache;
use think\Model;

class sys_config extends Model
{
    static public function getinfo($type=''){
        if($type==''){
            $sys=sys_config::select();
            return app('json')->go($sys);
        }
        $sys=sys_config::where(['type'=>$type])->select();
        return app('json')->go($sys);
    }

    static public function  editinfo(){
        $post=input('post.');

        foreach ($post as $item){

            $sys=sys_config::find($item['id']);
            $sys['value']=$item['value'];

            $sys['value']=$item['value'];
            $sys->save();
        }
        return app('json')->go(['msg'=>'更新成功']);
    }

    static public function getkey2(){  //获取查询关键词
        $keys=from_key::where('is_se','1')->select();
        $n=$keys->count();
           $arr=[
               'n'=>$n
           ];
        for($i=0;$i<$n;$i++){
            $arr['key'.($i+1)]=$keys[$i]['keyname'];
        }
        return $arr;
    }

    static public function  edkey2(){
        $keys=input('post.');
        $n=sys_config::find(12);
        $a[1]=sys_config::find(9);
        $a[2]=sys_config::find(10);
        $a[3]=sys_config::find(11);
        $n['value']= $keys['n'];
        $a[1]['value']= $keys['key1'];
        $a[2]['value']= $keys['key2'];
        $a[3]['value']= $keys['key3'];
        $n->save();
        $a[1]->save();
        $a[2]->save();
        $a[3]->save();
        $arr=[
            'n'=>$n['value'],
            'key1'=>$a[1]['value'],
            'key2'=>$a[2]['value'],
            'key3'=>$a[3]['value']
        ];
        return $arr;
    }

    static public function getfindvalue($id){
        $data=self::find($id);
        return $data['value'];
    }

}