<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class LabPagination extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'type' => 'isPositiveInteger',
        'limit' =>'require|isPositiveInteger',
        'title'=> 'chsAlphaNum',
        'status'=>'in:0,1'
    ];
}
