<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 1:32
 */

namespace app\api\model;


class Repair extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];

    public function device()
    {
        return $this->belongsTo('device', 'dev_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo('account', 'user_id', 'uid');
    }


}
