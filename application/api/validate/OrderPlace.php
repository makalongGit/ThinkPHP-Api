<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class OrderPlace extends BaseValidate
{
    protected $rule = [
        'title' => 'require',
        'detail' => 'require',
        'phone' => ['regex' => '^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$'],
        'order_date' => 'require',
        'lab_id' => 'require|isPositiveInteger',
        'num'=>'require|isPositiveInteger'
    ];
}
