<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 11:07
 */

namespace app\api\model;


class Account extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time','openid','password'];

    public function getTypeAttr($value, $data)
    {
        return $this->getAccountType($value, $data);
    }

    public static function check($ac, $pw, $type)
    {
        $user = self::where('uid', '=', $ac)->where('password', '=', $pw)->where('type', '=', $type)->find();
        return $user;
    }
}
