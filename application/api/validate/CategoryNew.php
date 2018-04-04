<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 21:46
 */

namespace app\api\validate;


class CategoryNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'parent_id' => 'require|isNotEmpty',
        'intro' => 'require|isNotEmpty'
    ];
}
