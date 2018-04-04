<?php
/**
 * User: makalong
 * Date: 2018/3/14
 * Time: 10:07
 */

namespace app\api\model;
use app\lib\exception\DeviceException;
use app\lib\exception\SuccessMessage;
class Device extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public function category()
    {
        return $this->belongsTo('category', 'cate_id', 'id');
    }
    public static function deleteDevice($ids)
    {
        $rs = self::destroy($ids);
        if (!$rs) {
            throw new DeviceException();
        }
        return new SuccessMessage();
    }
}