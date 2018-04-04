<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 14:40
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'pw' => 'require|isNotEmpty',
        'type' => 'require|isNotEmpty',
        //'captcha' => 'require'
    ];
}