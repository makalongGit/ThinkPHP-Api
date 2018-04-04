<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 21:46
 */

namespace app\api\validate;


class DeviceNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'cate_id' => 'require|isNotEmpty',
        'intro' => 'chsDash',
        'num' => 'number|isNotEmpty',
        'model'=>'require',
        'status' => 'require|in:0,1',
    ];
}
