<?php
/**
 * User: makalong
 * Date: 2018/3/14
 * Time: 10:07
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Device as DeviceModel;
use app\api\validate\DeviceNew;
use app\lib\exception\DeviceException;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\DevicePagination;
use app\lib\exception\SuccessMessage;

class Device extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createDevice,deleteDevice,updateDevice']
    ];
    public function getDevices()
    {
        $devices = DeviceModel::all([], 'category');
        if ($devices->isEmpty()) {
            throw new DeviceException();
        }
        $data['data'] = $devices;
        return json($data);
    }

    public function getAllDevices()
    {
        $validate = new DevicePagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $name = isset($dataArray['title']) ? '%' . $dataArray['title'] . '%' : '';
        $cate_id = isset($dataArray['type']) ? $dataArray['type'] : '';
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1';
        $labs = DeviceModel::all(function ($query) use ($page, $limit, $name, $cate_id, $status) {
            if ($cate_id) {
                $query->with(['category'])->where('name', 'like', $name)->where('cate_id', '=', $cate_id)->whereIn('status', $status)->page($page, $limit);
            } else {
                $query->with(['category'])->where('name', 'like', $name)->whereIn('status', $status)->page($page, $limit);
            }
        });
        $count = DeviceModel::all(function ($query) use ($name, $cate_id, $status) {
            if ($cate_id) {
                $query->with(['category'])->where('name', 'like', $name)->where('cate_id', '=', $cate_id)->whereIn('status', $status);
            } else {
                $query->with(['category'])->where('name', 'like', $name)->whereIn('status', $status);
            }
        })->count();
        return new SuccessMessage([
            'data' => ['items' => $labs, 'total' => $count]
        ]);
    }

    public function deleteDevice($ids)
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        DeviceModel::deleteDevice($ids);
        return new SuccessMessage();
    }

    public function createDevice()
    {
        $validate = new DeviceNew();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $res = DeviceModel::create($dataArray);
        return new SuccessMessage([
            'data' => [
                'id' => $res->id
            ]
        ]);
    }

    public function updateDevice($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new DeviceNew();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        DeviceModel::where('id', $id)->update($dataArray);
        return new SuccessMessage();
    }

    public function changeStatus($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $status = DeviceModel::where('id', $id)->value('status');
        if (is_null($status)) {
            throw new LabException();
        }
        $res = DeviceModel::update(['id' => $id, 'status' => ($status == 1) ? 0 : 1]);
        return new SuccessMessage([
            'data' => [
                'status' => $res->status
            ]
        ]);
    }
}
