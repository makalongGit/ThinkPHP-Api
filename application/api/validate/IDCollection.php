<?php
/**
 * User: makalong
 * Date: 2018/3/8
 * Time: 21:10
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];
    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的多个正整数'
    ];

    //ids = id1,id2,id3,...
    protected function checkIDs($values)
    {
        $values = explode(',', $values);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }
}