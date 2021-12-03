<?php


namespace app\model;


use app\controller\cms\Sys;
use ruhua\exceptions\BaseException;
use think\facade\Db;
use think\Model;
use think\model\concern\SoftDelete;

class order extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    static public function  addorder()
    {


        $re = request()->param();
        $re['time'] = strtotime($re['time']);
        $res = new order_post();
        $res->check($re);

        return $res->createorder($re);
    }


    static public function deleteall()
    {

        $url = '../xl/';
        $name = 'last';
        $re = order::select()->count();
        if ($re == 0) {
            return 1;
        }
        $has=from_key::select()->count();

        Db::table('order')->where(1)->delete();

        return 1;
    }


    static public function closeorder()
    {
        $re = request()->param();

        $q1 = order_post::arrfind($re);
        if ($q1) {
            $q1->delete();
        } else {
            return app('json')->go(['msg' => '你近期还没有预约']);
        }


        return app('json')->go(['msg' => '取消预约成功']);
    }

    static public function getorder()
    {
        $post=input('post.');
        $now=time();
        if($post['time']!=''){
            $time[0]=$post['time'][0];
            $time[1]=$post['time'][1];
        }else{
            $time[0]='';
        }

        $se=$post['keys'];
        $sen=[
            'id','key1','key2','key3'
        ];
        $f="'%$se%'";
        if($time[0]!=''&&$se!=''){

            $day=86400;
            $t1=strtotime($time[0]);
            $t2=strtotime($time[1])+$day;
            $sqll='(time < '.$t2.' and time > '.$t1.')';

            for($i=0;$i<4;$i++){
                $sql[$i]='('.$sqll.' and '.$sen[$i].' like '.$f.')';
            }

            $exsql=implode(' or ',$sql);


            $res = self::where($exsql)->order('time')->select();
        }
        else if($time[0]!=''){

            $day=86400;
            $t1=strtotime($time[0]);
            $t2=strtotime($time[1])+$day;

            $sql='time < '.$t2.' and time > '.$t1;

            $res = self::where($sql)->order('time')->select();
        }else if($se!=''){

            for($i=0;$i<4;$i++){
                $sql[$i]='('.$sen[$i].' like '.$f.')';
            }
            $exsql=implode(' or ',$sql);


            $res = self::where($exsql)->order('time')->select();


        }else{

            $res = self::order('time')->select();
        }
        foreach ($res as $i) {
            $i['json'] = json_decode($i['json']);
            $i['info'] = json_decode($i['info']);
            $i['time']=date('Y-m-d H:i:s',$i['time']);
        }

        return app('json')->go($res);
    }

    static public function off()
    {
        $switch = sys_config::where(['key' => 'order_ok'])->find();

        $switch['value'] = $switch['value'] ? '0' : '1';

        $switch->save();
        if ($switch['value'] == '0') {
            return app('json')->go(['msg' => '已经关闭预约', 'value' => $switch['value']]);
        } else {
            return app('json')->go(['msg' => '已经开启预约', 'value' => $switch['value']]);
        }
    }


    static public function getdate()
    {
        $d = sys_config::getfindvalue(22);
        $time = explode('@', $d); //获取开始日期和结束日期
        $year = date('Y-');
        $start_time = strtotime($year . $time[0]);
        $end_time = strtotime($year . $time[1]);

        if (empty($start_time)) {       //确定预约信息首日期
            $now = time(); //获取当前时间戳
        } else {
            $now = $start_time;
            if (time() > $now) {
                $now = time();
            }
        }
        $time_num = sys_config::getfindvalue(6); //一日的时间段数量
        $time_end = explode('@', sys_config::getfindvalue(7)); //时间段的时间分布，这里主要是取时间末
        $time_limit = explode('@', sys_config::getfindvalue(8)); //时间段预约限制
        $day = 3600 * 24;
        $for = 7;   //周末循环
        $total = sys_config::getfindvalue(5);  //可以看到的预约天数
        $order_ok = sys_config::getfindvalue(4);    //可以操作的日期天数
        $ok_time = time() + $day * $total;
        $ok = time() + $day * $order_ok;
        //当前时间大于最迟预约  或者是当前时间小于开放时间(当前时间加上可提前预约时间还小于开始时间)
        if (time() > strtotime($year . $time[1] . $time_end[$time_num * 2 - 1]) || $ok_time < $start_time) {    //数据是否可看
            throw new BaseException(['msg' => '不在预约期']);
        }
        $days = array();

        $skip = explode(',', sys_config::getfindvalue(23)); //跳过的周几

        for ($i = 0; $i < $for; $i++) {

            $timer = $now + $day * $i;
            if ($timer > $end_time + $day) {     //结束日，
                break;
            }

            $num = date("N", $timer);//获取今日是周几
            $k = 1;
            for ($j = 0; $j < count($skip); $j++) {   //检索该日期是否应该跳过
                if ($skip[$j] == $num) {
                    $k = 0;
                }
            }
            if ($k) {
                if (count($days) >= $total) break;
                $days[] = date("Y-m-d@@n月j日@@N", $now + $day * $i);
                $for += 1;
            }
        }


        $week = array(1 => '周一', 2 => '周二', 3 => '周三', 4 => '周四', 5 => '周五', 6 => '周六', 7 => '周日');
        foreach ($days as $k => $v) {
            $arr[$k] = explode('@@', $v);
            $data[$k]['nj'] = $arr[$k][1];//几月几日
            $data[$k]['week'] = $week[$arr[$k][2]];//周几
            $data[$k]['unix'] = $arr[$k][0];//日期
            $data[$k]['date'] = $data[$k]['nj'] . ' ' . $data[$k]['week'];
            for ($j = 1; $j <= $time_num; $j++) {
                $data[$k]['t' . $j . '_start'] = $time_end[$j * 2 - 2];
                $data[$k]['t' . $j . '_end'] = $time_end[$j * 2 - 1];
                $count = order::where('time', strtotime($data[$k]['unix'] . $data[$k]['t' . $j . '_end']))->count();
                $data[$k]['t' . $j . '_num'] = $time_limit[$j - 1] - $count;
                $data[$k]['t' . $j . 'time'] = $data[$k]['t' . $j . '_start'] . '-' . $data[$k]['t' . $j . '_end'];
            }

            $ok < $now ? $data[$k]['ok'] = 0 : $data[$k]['ok'] = 1;
        }

        return $data;
    }


}