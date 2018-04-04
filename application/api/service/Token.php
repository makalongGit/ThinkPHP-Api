<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 11:24
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use app\lib\exception\ForbidException;
use think\Request;
use think\Cache;
use think\Exception;
use app\lib\enum\ScopeEnum;

class Token
{
    public static function generateToken()
    {
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('setting.token_salt');
        return md5($randChars . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
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
                throw new Exception('尝试获取Token变量并不存在');
            }
        }
    }

    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbidException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbidException();
            }
        } else {
            throw new TokenException();
        }
    }
    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbidException();
            }
        } else {
            throw new TokenException();
        }
    }
}
