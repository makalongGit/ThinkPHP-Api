<?php
/**
 * User: makalong
 * Date: 2018/2/11
 * Time: 22:32
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Lab as LabModel;
use app\api\validate\IDCollection;
use app\api\validate\LaboratoryNew;
use app\lib\exception\LabException;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\SuccessMessage;
use app\api\validate\LabPagination;
use think\Db;

class Laboratory extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createLaboratory,deleteLaboratory,updateLaboratory,changeStatus']
    ];

    public function getAllLabs()
    {
        $validate = new LabPagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $name = isset($dataArray['title']) ? '%' . $dataArray['title'] . '%' : '';
        $cate_id = isset($dataArray['type']) ? $dataArray['type'] : '';
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1';
        $labs = LabModel::all(function ($query) use ($page, $limit, $name, $cate_id, $status) {
            if ($cate_id) {
                $query->with(['category'])->where('name', 'like', $name)->where('cate_id', '=', $cate_id)->whereIn('status', $status)->page($page, $limit);
            } else {
                $query->with(['category'])->where('name', 'like', $name)->whereIn('status', $status)->page($page, $limit);
            }
        });
        $count = LabModel::all(function ($query) use ($name, $cate_id, $status) {
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

    public function createLaboratory()
    {
        $validate = new LaboratoryNew();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $res = LabModel::create($dataArray);
        return new SuccessMessage([
            'data' => [
                'id' => $res->id
            ]
        ]);
    }

    public function deleteLaboratory($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        LabModel::deleteLaboratory($ids);
        return new SuccessMessage();
    }

    public function updateLaboratory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new LaboratoryNew();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        LabModel::where('id', $id)->update($dataArray);
        return new SuccessMessage();
    }

    public function changeStatus($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $status = LabModel::where('id', $id)->value('status');
        if (is_null($status)) {
            throw new LabException();
        }
        $res = labModel::update(['id' => $id, 'status' => ($status == 1) ? 0 : 1]);
        return new SuccessMessage([
            'data' => [
                'status' => $res->status
            ]
        ]);
    }
}
