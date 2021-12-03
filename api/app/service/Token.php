<?php


namespace app\service;


use app\lib\exception\BaseException;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }

    public static function generateToken()
    {
        $randChar = self::getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('setting.token_salt');
        return md5($randChar.$timestamp.$tokenSalt);
    }

    public function saveToCache($cachedValue)
    {
        $key = self::generateToken();//生成token

        $value = json_encode($cachedValue);//把value转化为字符串

        $expire_in = config('setting.token_expire_in');//有效时间

        //写入缓存
        $requst = cache($key, $value, $expire_in);//写入缓存

        if (!$requst) {
            throw new BaseException([
                //覆盖默认值
                'msg' => '服务器缓存异常！',
                'errcode' => 1005
            ]);
        }

        return $key;//返回令牌到客户端
    }

    public static function getCurrentIdentity($keys)
    {
        $token = Request::header('token');
        $identities = Cache::get($token);

        if (!$identities)
        {
            throw new BaseException(['errorCode'=>'401','msg'=>'token已过期']);
        }
        else
        {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $identities))
                {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars)
        {
            throw new \ruhua\exceptions\BaseException(['msg'=>'token过期或者不存在','errorCode'=>401]);
        }
        else {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else{
                throw new BaseException(['code'=>401,'msg'=>'尝试获取的Token变量并不存在']);
            }
        }
    }
}