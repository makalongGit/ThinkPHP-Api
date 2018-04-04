<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:08
 */

namespace app\api\validate;


class RepairNew extends BaseValidate
{
    protected $rule = [
        'dev_id'=>'require',
        'detail'=>'require',
        'model'=>'require',
    ];
}
