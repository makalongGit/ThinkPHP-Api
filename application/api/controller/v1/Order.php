<?php
/**
 * User: makalong
 * Date: 2018/3/9
 * Time: 16:19
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\SuccessMessage;
use app\api\validate\OrderPagination;
use app\api\validate\AuditingBook;
use app\api\validate\IDMustBePositiveInt;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'getAllOrder,auditing']
    ];

    public function getAllOrder()
    {
        $validate = new OrderPagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1,2,3';
        $date = isset($dataArray['date']) ? $dataArray['date'] : '';
        $title=isset($dataArray['title']) ? '%'.$dataArray['title'].'%' : '';
        $items = $this->getItemsByParams($page, $limit, $status, $date,$title);
        $count = $this->getCountByParams($status, $date,$title);
        return new SuccessMessage([
            'data' => [
                'items' => $items,
                'total' => $count
            ]
        ]);
    }

    public function getOrderByAccount()
    {
        $validate = new OrderPagination();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('get.'));
        $id = TokenService::getCurrentTokenVar('uid');
        $page = $dataArray['page'];
        $limit = $dataArray['limit'];
        $status = (!empty($dataArray['status']) || $dataArray['status'] == '0') ? $dataArray['status'] : '0,1,2,3';
        $date = isset($dataArray['date']) ? $dataArray['date'] : '';
        $title=isset($dataArray['title']) ? '%'.$dataArray['title'].'%' : '';
        $items = $this->getItemsByParams($page, $limit, $status, $date,$title)->hidden(['account']);
        $count = $this->getCountByParams($status, $date,$title);
        $myItems = $items->filter(function ($item) use ($id) {
            if ($item['user_id'] == $id) {
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
        $validate = new OrderPlace();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        $uid = TokenService::getCurrentTokenVar('uid');
        $order = new OrderService();
        $status = $order->place($uid, $dataArray);
        return new SuccessMessage([
            'status' => $status
        ]);
    }

    public function auditing($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new AuditingBook();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        OrderModel::where('id', $id)->update($dataArray);
        return new SuccessMessage();
    }
    public function deleteOrder($id){
      (new IDMustBePositiveInt())->goCheck();
      $order_user=OrderModel::where('id',$id)->value('user_id');
      $uid=TokenService::getCurrentTokenVar('uid');
      if($order_user !== $uid){
        throw new ForBidException();
      }else{
        OrderModel::destroy($id);
        return new SuccessMessage();
      }
    }
    public function getItemsByParams($page, $limit, $status, $date,$title)
    {
        $orders = OrderModel::all(function ($query) use ($page, $limit, $status, $date,$title) {
            if ($date) {
                $query->with(['account', 'laboratory', 'laboratory.category'])->where('order_date', '=', $date)->whereIn('status', $status)->where('title','like',$title)->page($page, $limit);
            } else {
                $query->with(['account', 'laboratory', 'laboratory.category'])->whereIn('status', $status)->where('title','like',$title)->page($page, $limit);
            }
        });
        return $orders;
    }

    public function getCountByParams($status, $date,$title)
    {
        $count = OrderModel::all(function ($query) use ($status, $date,$title) {
            if ($date) {
                $query->with(['account', 'laboratory', 'laboratory.category'])->where('order_date', '=', $date)->where('title','like',$title)->whereIn('status', $status);
            } else {
                $query->with(['account', 'laboratory', 'laboratory.category'])->where('title','like',$title)->whereIn('status', $status);
            }
        })->count();
        return $count;
    }
}
