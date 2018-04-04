<?php
/**
 * User: makalong
 * Date: 2018/3/28
 * Time: 22:18
 */

namespace app\api\validate;


class CirculatePlace extends BaseValidate
{
    protected $rule = [
        'detail' => 'require',
        'phone' => ['regex' => '^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$'],
        'borrow_date' => 'require',
        'return_date' => 'require',
        'dev_id' => 'require|isPositiveInteger',
        'count'=>'require|number'
    ];
}
