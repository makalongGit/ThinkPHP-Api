<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class OrderPagination extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'limit' =>'require|isPositiveInteger',
        'date'=> 'chsAlphaNum',
        'status'=>'in:0,1,2,3',
        'title'=>'chsAlphaNum'
    ];
}
