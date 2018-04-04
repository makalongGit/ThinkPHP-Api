<?php
/**
 * User: makalong
 * Date: 2018/2/11
 * Time: 22:33
 */

namespace app\api\model;


use app\lib\exception\LabException;
use app\lib\exception\SuccessMessage;

class Lab extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];


    public function category()
    {
        return $this->belongsTo('category', 'cate_id', 'id');
    }

    public static function deleteLaboratory($ids)
    {
        $rs = self::destroy($ids);
        if (!$rs) {
            throw new LabException();
        }
        return new SuccessMessage();
    }
}
