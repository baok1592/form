<?php
/**ssss
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/10 0010
 * Time: 16:51
 */

namespace ruhua\services;

use ruhua\model\User as UserModel;
use think\facade\Log;

class MergeService
{
    /**
     * 合并两个用户
     * @param $main_uid --主账号
     * @param $field    --xcx,gzh,app,oponid字段名
     * @param $openid   --需要合并删除的oponId。
     * @param $type --1手机关联，2平台uniobid关联
     * @return string
     */
    public function mergeUser($main_uid, $field, $openid, $type)
    {
        $where[$field] = $openid;
        if ($type == 1) {
            $where['mobile'] = null;
        } else if ($type == 2) {
            $where['unionid'] = null;
        }
        $res = UserModel::where($where)->find();
        if (!$res) {
            return '';
        }
        //会员
        $vip_state = $this->mergeVip($main_uid, $res['id']);
        if (!$vip_state) {
            return '状态错误';
        }
    }

    public function mergePoints($main_uid, $uid)
    {
        $main_uid_points = UserModel::where('id', $main_uid)->find();
        $uid_points = UserModel::where('id', $uid)->find();
        $main_uid_points['points'] += $uid_points['points'];
        $main_uid_points->save();
        return $uid_points['points'];
    }

}