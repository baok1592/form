<?php
declare (strict_types = 1);

namespace app\middleware;

use app\model\sys_config;
use app\service\Token;
use ruhua\exceptions\BaseException;

class Checkcms
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

            $id=Token::getCurrentTokenVar('aid');
            if($id){
                return $next($request);
            }

    }
}
