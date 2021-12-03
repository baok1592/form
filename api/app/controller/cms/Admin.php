<?php


namespace app\controller\cms;


use app\model\admin as adminmodel;
use app\service\Token;
use ruhua\exceptions\BaseException;


class Admin
{
    public function check(){

    }

    public function editPSW(){
        $post=input('post.');
        $id=Token::getCurrentTokenVar('aid');

        $admin=adminmodel::find($id);
        if($admin['pwd']!=md5($post['oldpwd'])){
            throw new BaseException(['msg'=>'旧密码不对']);
        }
        $admin['pwd']=md5($post['pwd']);
        $admin->save();
        return app('json')->go(['id'=>$admin['id']]);
    }

    public function login(){
        $post=input('post.');
        $post['pwd']=md5($post['pwd']);
        $res=adminmodel::where(['name'=>$post['name'],'pwd'=>$post['pwd']])->find();

        if(!$res){
                throw new BaseException(['msg'=>'账号或者密码错误']);
        }

        $t=new Token();
        $cachedValue=[
            'aid'=>$res['id'],
        ];
        $token=$t->saveToCache($cachedValue);



        return app('json')->go(['is_login'=>'true','token'=>$token]);
    }

    public function add(){
        $post=input('post.');
        $post['pwd']=md5($post['pwd']);
        $if=adminmodel::where('name',$post['name'])->find();
        if($if!='')
            throw new BaseException(['msg'=>'用户名已存在']);

        $res=adminmodel::create($post);
        return app('json')->go(['id'=>$res['id'],'name'=>$res['name']]);
    }

    public function del(){
        $post=input('post.');
        $id=$post['id'];
        adminmodel::find($id)->delete();
        return app('json')->go(['msg'=>'删除成功']);
    }

    public function get(){
        $res=adminmodel::select();
        return app('json')->go($res);
    }

    public function ed_pwd(){
        $post=input('post.');
        $id=$post['id'];

        $admin=adminmodel::find($id);
        if($admin['pwd']!=md5($post['oldpwd'])){
            throw new BaseException(['msg'=>'旧密码不对']);
        }
        $admin['pwd']=md5($post['pwd']);
        $admin->save();
        return app('json')->go(['id'=>$admin['id']]);
    }
}