<?php
/**
 * User: makalong
 * Date: 2018/3/9
 * Time: 16:19
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\validate\CirculatePlace;
use app\api\service\Order as OrderService;
use app\lib\exception\SuccessMessage;
use app\api\model\Borrow as OuiModel;
use app\api\validate\OuiPagination;
use app\api\validate\AuditingOui;
use app\api\validate\IDMustBePositiveInt;

class Circulate extends BaseController
{
    // protected $beforeActionList = [
    //     'checkSuperScope' => ['only' => 'getAllOuiOrder']
    // ];

    public function getAllOuiOrder()
    {
        $validate = new OuiPagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1,2,3';
        $borrow_date = isset($dataArray['borrow_date']) ? '%' . $dataArray['borrow_date'] . '%' : '';
        $return_date = isset($dataArray['return_date']) ? '%' . $dataArray['return_date'] . '%' : '';
        $orders = $this->getItemsByParams($page, $limit, $status, $borrow_date, $return_date);
        $count = $this->getCountByParams($status, $borrow_date, $return_date);
        return new SuccessMessage([
            'data' => ['items' => $orders, 'total' => $count]
        ]);
    }

    public function getOuiOrderByAccount()
    {
        $validate = new OuiPagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $id = TokenService::getCurrentTokenVar('uid');
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1,2,3';
        $borrow_date = isset($dataArray['borrow_date']) ? '%' . $dataArray['borrow_date'] . '%' : '';
        $return_date = isset($dataArray['return_date']) ? '%' . $dataArray['return_date'] . '%' : '';
        $items = $this->getItemsByParams($page, $limit, $status, $borrow_date, $return_date);
        $count = $this->getCountByParams($status, $borrow_date, $return_date);
        $myItems = $items->hidden(['account'])->filter(function ($item) use ($id) {
            if ($item['user_id'] == $id ) {
                return true;
            } else {
                return false;
            }
        });
        return new SuccessMessage([
            'data' => [
                'items' => $myItems,
                'total' => $count
            ]
        ]);
    }

    /*
     * 1.判断token是否存在，且能查到对应用户信息
     * 2.对接收来的数据验证，预约时间和日期规则的验证
    */
    public function placeOrder()
    {
        $validate = new CirculatePlace();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        $uid = TokenService::getCurrentTokenVar('uid');
        $order = new OrderService();
        $status = $order->iouPlace($uid, $dataArray);
        return new SuccessMessage([
            'status' => $status
        ]);
    }

    public function auditing($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new AuditingOui();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        OuiModel::where('id', $id)->update($dataArray);
        return new SuccessMessage();
    }

    public function getItemsByParams($page, $limit, $status, $borrow_date, $return_date)
    {
        $orders = OuiModel::all(function ($query) use ($page, $limit, $status, $borrow_date, $return_date) {
            $query->with(['account', 'device', 'device.category'])->where('borrow_date', 'like', $borrow_date)->where('return_date', 'like', $return_date)->whereIn('status', $status)->page($page, $limit);
        });
        return $orders;
    }

    public function getCountByParams($status, $borrow_date, $return_date)
    {
        $count = OuiModel::all(function ($query) use ($status, $borrow_date, $return_date) {
            $query->with(['account', 'device', 'device.category'])->where('borrow_date', 'like', $borrow_date)->where('return_date', 'like', $return_date)->whereIn('status', $status);
        })->count();
        return $count;
    }

}
