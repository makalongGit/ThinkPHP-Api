<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 14:33
 */

namespace app\api\service;


use app\api\model\Account as UserModel;
use app\lib\exception\TokenException;
use think\Request;
class AppToken extends Token
{
    public function get($ac, $pw, $type)
    {
        $user = UserModel::check($ac, $pw, $type);
        if (!$user) {
            throw new TokenException([
                'msg' => '授权失败',
                'errorCode' => 1004
            ]);
        } else {
            $scope = $user->scope;
            $uid = $user->uid;
            $values = [
                'scope' => $scope,
                'uid' => $uid
            ];
            $token = $this->saveToCache($values);
            return $token;
        }
    }

    private function saveToCache($values)
    {
        $token = self::generateToken();
        $expire_in = config('setting.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if (!$result) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005,
            ]);
        }
        return $token;
    }

    public function cleanCacheByToken()
    {
        $token = Request::instance()->header('token');
        $result = cache($token, null);
        if (!$result) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005,
            ]);
        }
    }
}
