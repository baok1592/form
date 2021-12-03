<?php

/**
 * 如花拼团开源系统 -- 永久免费
 * =========================================================
 * 官方网址：http://www.phps.shop
 * 作者：光爵【API + 后台】 、 小草【小程序 + WAP】
 * QQ 交流群：728615087
 * Version：1.0.0
 */
namespace app\http\middleware;

//中间件，验证token，检测权限
//该文件可直接拷贝在中间件里面使用
use ruhua\services\TokenService;
use ruhua\auth\Auth;
use think\facade\Request;

class CheckCms
{
    public function handle($request, \Closure $next)
    {
        $res=TokenService::getCurrentTokenVar('scope');
        $aid = TokenService::getCurrentTokenVar('aid');
        $rule = Request::url();
        if(strchr($rule,'?'))
            $rule=substr($rule,0,strripos($rule,'?'));
        $data = (new Auth())->check($rule,$aid);
        if ($res == true && $data == true) {
            return $next($request);
        }
        return app('json')->fail('没有权限');
    }
}