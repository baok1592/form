<?php

namespace ruhua\services;



use ruhua\model\User as UserModel;
use ruhua\exceptions\BaseException;
use ruhua\exceptions\TokenException;
use think\facade\Cache;
use think\facade\Request;
use Firebase\JWT;

//API的token文件，用于：生成token、
class TokenService
{
    protected $tokenExpire;

    function __construct()
    {
        $this->tokenExpire = config('setting.token_expire_in'); //token缓存有效时间
    }


    //通过token获取该条缓存数据中指定的字段
    public static function getCurrentTokenVar($key1)
    {
        $token=Request::header('token');
        $key = '344'; //key要和签发的时候一样，唯一标识
        try {
            JWT\JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT\JWT::decode($token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res=json_decode(json_encode($arr['data']), true);
            //dump($res);
            return $res[$key1];
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            throw new TokenException(['msg'=>'签名不正确']);
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            throw new TokenException(['msg'=>'签名在某个时间点之后才能用']);
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            throw new TokenException(['msg'=>'token过期']);
        }catch(\Exception $e) {  //其他错误
            throw new TokenException(['msg'=>'获取的值不存在！'.$e->getMessage()]);
        }
    }

    //通过token获取该条缓存数据中指定的字段
    public static function getCTVar($key)
    {
        $token = Request::header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                return false;
            }
        }
    }

    //放入缓存
    public function saveCache($cachedValue)
    {
        $key = '344'; //key，唯一标识
        $time = time(); //当前时间
        $token = [
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time+7200, //过期时间,这里设置2个小时
            'data' => $cachedValue
        ];
        $token = JWT\JWT::encode($token, $key,'HS256'); //签发token
        //Cache::put($token,$data);
        return $token;
    }

    //验证toen
    public static function verifyToken($token)
    {
        $key = '344'; //key要和签发的时候一样，唯一标识
        try {
            JWT\JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT\JWT::decode($token, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            return true;
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            return false;
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            return false;
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            return false;
        }catch(\Exception $e) {  //其他错误
            return false;
        }
    }

    //检测某订单中的uid是否以token中的uid一致，为同一人
    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new TokenException(['msg' => '检查UID时必须传入UID']);
        }
        $currentOperateUID = self::getCurrentTokenVar('uid');
        if ($currentOperateUID != $checkedUID) {
            return false;
        }
        return true;
    }
    //通过token获取uid
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $user = UserModel::find($uid);
        if (!$user) {
            throw new BaseException(['msg' => '无该用户信息']);
        }
        return $uid;
    }


}