<?php


namespace app\model;


use app\validate\key;
use ruhua\exceptions\BaseException;
use think\facade\Db;
use think\Model;
use think\model\concern\SoftDelete;

class from_key extends Model
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    static public function add()
    {
        $re = request()->param();
        /*   验证
        $validate=new key();
        $validate->batch()->check($re);
        $msg = $validate->getError();
        if ($msg) {
            throw new BaseException(['msg' => $msg]);
        }*/

        $res = self::create($re);
        return app('json')->go(['msg' => '新建成功', 'id' => $res['id']]);
    }

    static public function remove()
    {
        $re = request()->param();

        $res = self::where(['keyname' => $re['keyname']])->find()->delete();

        return app('json')->go(['msg' => '删除成功']);
    }


    static public function edit()
    {
        $re = request()->param();

        foreach ($re as $item) {
            $key = self::where(['name' => $item['name']])->find();
            if ($key) {
                $key['name'] = $item['name'];
                $key['type'] = $item['type'];
                $key['msg'] = $item['msg'];
                $key['is_ok'] = $item['is_ok'];
                $key->save();
            }

        }

        return app('json')->go(['msg' => '更新成功']);

    }

    static public function get()
    {
        $key = self::select();
        return app('json')->go($key);
    }

    static public function deleteall(){

      //  $has=Db::table('order')->select()->count();

//        if($has!=0){
//            order::where('1')->
//        }
        $has=Db::table('from_key')->select()->count();
        if($has!=0){
            Db::table('from_key')->where(1)->delete();
        }
    }

    static public function getnum(){ //获取当前关键词个数
        $key = from_key::select();
        $n = $key->count();
        return $n;
    }
}