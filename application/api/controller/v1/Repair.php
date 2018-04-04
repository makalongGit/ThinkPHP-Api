<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 11:04
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\Repair as RepairModel;
use app\api\validate\RepairNew;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\RepairException;
use app\api\validate\RepairPagination;

class Repair extends BaseController
{
    public function createRepair(){
        $validate=new RepairNew();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $uid = TokenService::getCurrentTokenVar('uid');
        $dataArray['user_id']=$uid;
        $res = RepairModel::create($dataArray);
        return new SuccessMessage([
            'data' => [
                'id' => $res->id
            ]
        ]);
    }

    public function getAllRepair(){
      $validate=new RepairPagination();
      $validate->goCheck();
      $dataArray = $validate->getDataByRule(input('get.'));
      $page = $dataArray['page'];
      $limit = $dataArray['limit'];
      $status=(!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1';
      $repairs=RepairModel::all(function($query) use ($page,$limit,$status){
      $query->with(['account','device','device.category'])->whereIn('status', $status)->page($page, $limit);
      });
      $count=RepairModel::all(function($query) use ($status){
        $query->with(['account','device','device.category'])->whereIn('status', $status);
      })->count();
      return new SuccessMessage([
          'data' => ['items' => $repairs, 'total' => $count]
      ]);
    }

    public function changeStatus($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $status = RepairModel::where('id', $id)->value('status');
        if (is_null($status)) {
            throw new RepairException();
        }
        $res = RepairModel::update(['id' => $id, 'status' => ($status == 1) ? 0 : 1]);
        return new SuccessMessage([
            'data' => [
                'status' => $res->status
            ]
        ]);
    }
}
