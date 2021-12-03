<?php


namespace app\controller\cms;

require '../vendor/autoload.php';

use app\model\excle;
use app\model\sys_config;
use ruhua\exceptions\BaseException;


class Excel
{
    public function get()
    {
            $infos = excle::order('lv desc')->order('id desc')->select();
        foreach ($infos as $info){
            $info['frist_name']=explode('@',$info['frist_name']);
            $info['search_key']=explode('@',$info['search_key']);

            $info['frist_name']=implode('/',$info['frist_name']);
            $info['search_key']=implode('/',$info['search_key']);

        }
        return app('json')->go($infos);
    }

    public function getse($id){
        $infos=excle::find($id);
        $info['se_key']=explode('@',$infos['frist_name']);
        $info['search_key']=explode('@',$infos['search_key']);
        $info['n']=count($info['search_key']);
        return app('json')->go($info);
    }

    public function del(){
        $post=input('post.');
        $id=$post['id'];
        return excle::find($id)->delete();
    }

    public function new($name){
        return excle::newname($name);
    }

    public function dd($name = '', $url = ''){

        $res=excle::dd($name,$url);
        return app('json')->go($res);
    }


    public function importexcel()
    {
            return excle::imexcel();
    }

    public function select($id)
    {  //缓存查询
       return excle::Chaceselect($id);

    }

    public function givesearch(){           //设置项目的查询关键词,名字
        $re=request()->post();  //post

        $n=$re['n'];
        $id=$re['id'];

        for($i=1;$i<=$n;$i++)
            $arr[$i]=$re['key'.$i];

        $str=implode('@',$arr);
        if(excle::setsearch($id,$str)){
            $res=excle::find($id);
            $res['lv']=$re['lv'];
            $res['xname']=$re['xname'];
            $res->save();
            return app('json')->go(['msg'=>'项目'.$id.'查询关键词已设置','new'=>$res]);
        }
        throw new BaseException(['msg'=>'新增失败']);
    }

    public function exselect(){ //excel查询
            //更新缓存
        $re=request()->post();
        return excle::exselect($re);
    }

    public function getexcel($id)
    {   //缓存中获取数据数组
        $data = excle::getexcel($id);
        return app('json')->go($data);
    }

    public function getexcelarr($id)
    {//表数据放入缓存
        $data = excle::getexcelarr($id);

        return app('json')->go($data);
    }

    public function newdata($id){   //根据id找到某项目并更新excel缓存;
         return   excle::F5($id);
    }

    public function exceladd(){  //对某表进行新增数据   //暂时不用
        $newdata=request()->post();
        if(excle::addnewdata($newdata['id'],$newdata)){
            return app('json')->go(['msg'=>'数据已加入']);
        }

    }


    public function upload(){
        $file=request()->file('file');
        $savename = \think\facade\Filesystem::putFile( 'excel', $file);
        $savename=str_replace('\\', '/', $savename );
        $savename='../public/uploads/'.$savename;

        return app('json')->go(['url'=>$savename]);

    }

    public function move(){
        $post=input('post.');

        $url=$post['url'];

        $sheetdata = excle::getarr($url);

        if (!$sheetdata) {
            throw new BaseException(['msg' => '该文件地址可能有误']);
        }
        $f_name='';
        $j=0;
        foreach ($sheetdata as $i){    //拿出表头

            foreach ($i as $value){
                if ($j == 0) {
                    $f_name = $value;
                    $j++;
                }
                else {
                    $f_name = $f_name . '@' . $value;
                }
            }
            break;
        }
        $data = [
            'name' =>'',
            'url' => $url,
            'lv'=>0,
            'frist_name' => $f_name,
            'xname'=>"  "
        ];

        $res = excle::create($data);
        return app('json')->go($res);

    }






}