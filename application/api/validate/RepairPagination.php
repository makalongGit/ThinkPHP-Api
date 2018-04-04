<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class RepairPagination extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'limit' =>'require|isPositiveInteger',
        'status'=>'in:0,1',
    ];
}
