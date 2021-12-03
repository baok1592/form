<?php


namespace app\model;


use app\controller\cms\Sys;
use ruhua\exceptions\BaseException;
use think\facade\Db;
use think\Model;

class order_post
{
    static public function cout()
    {     //获取某个预约时间段的人数
        $re = request()->param();
        $time2 = $re['time2'];
        $time1 = $re['time1'];
        if ($time1 > $time2) {
            $t = $time1;
            $time1 = $time2;
            $time2 = $t;
        }
        $str = 'time>=' . $time1 . ' and time<=' . $time2;
        $n = order::where($str)->select()->count();
        return app('json')->go(['order_num' => $n]);
    }

    public function check($re = '')
    {
        $long=sys_config::getfindvalue(21);
        $order_ok=sys_config::getfindvalue(4);
        if($re['time']<time()){
            throw new BaseException(['msg' => '预约失败，请重新选择时间段']);
        }
        $nn=$re['time']-time();
        $nn=intval($nn / 86400);
        if($nn>$order_ok){

            throw new BaseException(['msg' => '该日期预约还没有开始'.$nn]);
        }
        $q1 = self::arrfind($re);
        if ($q1) {
            $timediff = abs($q1['time'] - $re['time']);
            $days = intval($timediff / 86400);

            if ($days <= $long)
                throw new BaseException(['msg' => '近期已经有预约了']);
        }
        return $re;

    }

    static public function arrfind($re)  //关键词查询sql
    {
        $sys = new sys_config();
        $arr = $sys->getkey2();

        if ($arr['n'] == '1') {
            $q1 = order::where(['key1' => $re[$arr['key1']], 'is_ok' => 1])->find();

        }
        if ($arr['n'] == '2') {
            $q1 = order::where(['key1' => $re[$arr['key1']], 'key2' => $re[$arr['key2']]])->order( 'time','desc')->find();

        }

        if ($arr['n'] == '3') {
            $q1 = order::where(['key1' => $re[$arr['key1']], 'key2' => $re[$arr['key2']], 'key3' => $re[$arr['key3']], 'is_ok' => 1])->find();
        }


        return $q1;
    }

    public function create($re = '') //提交预约时的转化json字符串
    {   //动态创建json
        $keys = Db::table('from_key')->select();
        $n = count($keys);
        $sys = Db::table('sys_config')->select();
        $key_n = $sys[11]['value'];
        for ($j = 0; $j < $key_n; $j++) {
            $key_num[$j] = $sys[$j + 8]['value'];
        }
        $i = 0;
        while ($i < $n) {
            $key[$keys[$i]['keyname']] = $re[$keys[$i]['keyname']];
            $i++;
        }
        $s = json_encode($key);
        $order = order::create($re);
        $order['json'] = $s;
        $order['key1'] = $re[$key_num[0]];
        if ($key_n >= 2) {
            $order['key2'] = $re[$key_num[1]];
        }
        if ($key_n == 3) {
            $order['key3'] = $re[$key_num[2]];
        }
        $order->save();
        return app('json')->go(['msg' => '预约成功']);
    }


    public function createorder($re = ''){

        $keys = from_key::select();
        $keyn = count($keys);
        $se=from_key::where('is_se','1')->select();
        $sen=count($se);
        $order = order::create($re);
        for ($j = 0; $j < $sen; $j++) {

            $key_num[$j] = $se[$j]['keyname'];

        }

        $i = 0;

        while ($i < $keyn) {
                $key2[$keys[$i]['name']]=$re[$keys[$i]['keyname']];
                $key[$keys[$i]['keyname']] = $re[$keys[$i]['keyname']];
            $i++;
        }

        $s = json_encode($key,JSON_UNESCAPED_UNICODE);
        $s2 = json_encode($key2,JSON_UNESCAPED_UNICODE);

        $order['json'] = $s;
        $order['info'] = $s2;
        $order['key1'] = $re[$key_num[0]];
        if ($sen >= 2) {
            $order['key2'] = $re[$key_num[1]];
        }
        if ($sen == 3) {
            $order['key3'] = $re[$key_num[2]];
        }

        $order->save();
        return app('json')->go(['id'=>$order['id'],'msg' => '预约成功']);
    }
}