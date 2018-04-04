<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 21:46
 */

namespace app\api\validate;


class AccountNew extends BaseValidate
{
    protected $rule = [
        'uname' => 'require|isNotEmpty',
        'intro' => 'chsDash',
        'uid' => 'isNotEmpty',
        'sex'=>'require|in:1,0',
        
    ];
}
