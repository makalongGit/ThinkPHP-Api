<?php
/**
 * User: makalong
 * Date: 2018/2/3
 * Time: 18:34
 */

namespace app\api\model;


use think\Model;
use traits\model\SoftDelete;
use app\lib\enum\AccountTypeEnum;
use app\lib\enum\CommonTypeEnum;
use app\lib\enum\OrderStatusEnum;

class BaseModel extends Model
{
    //软删除
    use SoftDelete;
    protected static $deleteTime = 'delete_time';

    public function getAccountType($value, $data = '')
    {
        $accountType = '';
        switch ($value) {
            case AccountTypeEnum::STUDENT :
                $accountType = 'student';
                break;
            case AccountTypeEnum::TEACHER :
                $accountType = 'teacher';
                break;
            case AccountTypeEnum::ADMIN :
                $accountType = 'admin';
                break;
        }
        return $accountType;

    }

    public function getOrderStatusType($value, $data = '')
    {
        $statusType = '';
        switch ($value) {
            case OrderStatusEnum::AUDIT :
                $statusType = '审核中';
                break;
            case OrderStatusEnum::PASS :
                $statusType = '已通过';
                break;
            case OrderStatusEnum::FAIL :
                $statusType = '未通过';
                break;
        }
        return $statusType;
    }
}
