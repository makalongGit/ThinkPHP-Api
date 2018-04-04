<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class AccountPagination extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'limit' =>'require|isPositiveInteger',
        'title'=> 'chsAlphaNum',
        'sex'=>'in:0,1',
        'uid'=>'number',
        'type' => 'require|in:1,2,3'
    ];
}
