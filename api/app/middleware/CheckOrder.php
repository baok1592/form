<?php
declare (strict_types = 1);

namespace app\middleware;

use app\model\sys_config;
use ruhua\exceptions\BaseException;

class CheckOrder
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $switch=sys_config::where(['key'=>'order_ok'])->find();
        $switch=$switch['value'];
        if($switch=='0'){
            return $next($request);
        }
        else{
            throw new BaseException(['msg'=>'预约尚未开放']);
        }

    }
}
