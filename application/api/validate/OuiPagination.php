<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class OuiPagination extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'limit' =>'require|isPositiveInteger',
        'borrow_date'=> 'alphaDash',
        'status'=>'in:0,1,2,3',
        'return_date'=>'alphaDash',
    ];
}
