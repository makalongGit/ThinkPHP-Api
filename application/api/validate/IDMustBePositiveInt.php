<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 11:22
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $msg = [
        'id' => 'id必须是正整数'
    ];
}