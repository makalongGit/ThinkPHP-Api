<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 21:46
 */

namespace app\api\validate;


class LaboratoryNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'cate_id' => 'require|isNotEmpty',
        'intro' => 'chsDash',
        'status' => 'require|in:0,1',
        'start_time'=>'require',
        'end_time'=>'require'
    ];
}
