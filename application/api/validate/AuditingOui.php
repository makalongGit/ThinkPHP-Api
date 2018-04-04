<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 21:46
 */

namespace app\api\validate;


class AuditingOui extends BaseValidate
{
    protected $rule = [
        'status' => 'require|in:1,2',
        'reason' => 'require|chsDash',
    ];
}
