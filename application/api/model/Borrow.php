<?php
/**
 * User: makalong
 * Date: 2018/3/28
 * Time: 22:12
 */

namespace app\api\model;



class Borrow extends BaseModel
{
    protected $hidden = [ 'update_time', 'delete_time'];

    public function device()
    {
        return $this->belongsTo('device', 'dev_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo('account', 'user_id', 'uid');
    }
}
