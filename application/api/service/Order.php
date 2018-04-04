<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:39
 */

namespace app\api\service;

use app\api\model\Lab as LabModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\api\model\Order as OrderModel;
use app\api\model\Borrow as BorrowModel;
use app\lib\exception\SuccessMessage;
use app\api\model\Device as DeviceModel;

class Order
{
    protected $uid;
    protected $labInfo;
    protected $orderInfo;
    protected $ownInfo;
    protected $deviceInfo;

    public function place($uid, $orderInfo)
    {
        $this->uid = $uid;
        $this->orderInfo = $orderInfo;

        //对接收来的数据验证，预约时间和日期规则的验证
        $this->labInfo = $this->getLabByOrder($orderInfo);
        $this->checkStatus($this->labInfo);
        $this->createOrder($this->orderInfo);
    }

    private function createOrder($dataArray)
    {
        $dataArray['user_id'] = $this->uid;
        $dataArray['status'] = OrderStatusEnum::AUDIT;
        OrderModel::create($dataArray);
    }

    private function getLabByOrder($orderInfo)
    {
        $labInfo = LabModel::get($orderInfo['lab_id']);
        return $labInfo;
    }

    private function getDeviceByOrder($ownInfo)
    {
        $deviceInfo = DeviceModel::get($ownInfo['dev_id']);
        return $deviceInfo;
    }

    private function checkStatus($Info)
    {
      $status=$Info->getData('status');
        if ($status == 0) {
            throw new OrderException([
                'msg' => $status . '暂不开放'
            ]);
        }
    }

    private function checkStock($Info)
    {
        if ($Info['stock'] == 0) {
            throw new OrderException([
                'msg' => $Info['name'] . '暂无存货'
            ]);
        }
    }

    //设备借用
    public function iouPlace($uid, $ownInfo)
    {
        $this->uid = $uid;
        $this->ownInfo = $ownInfo;
        //数据验证
        $this->deviceInfo = $this->getDeviceByOrder($this->ownInfo);
        //检验状态
        $this->checkStatus($this->deviceInfo);
        //检验数量
        $this->checkStock($this->deviceInfo);
        $this->createOwn($this->ownInfo);
    }

    public function createOwn($dataArray)
    {
        $dataArray['user_id'] = $this->uid;
        $dataArray['status'] = OrderStatusEnum::AUDIT;
        BorrowModel::create($dataArray);
    }
}
