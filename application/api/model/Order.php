<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 1:32
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = [ 'update_time', 'delete_time'];

    public function laboratory()
    {
        return $this->belongsTo('lab', 'lab_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo('account', 'user_id', 'uid');
    }


}
