<?php
/**
 * User: makalong
 * Date: 2018/3/30
 * Time: 13:58
 */

namespace app\api\validate;


class UpdatePw extends BaseValidate
{
    protected $rule = [
        'initpass' => 'require',
        'password' => 'require|length:6,15'
    ];
}
