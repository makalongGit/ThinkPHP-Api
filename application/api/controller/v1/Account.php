<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 11:04
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\AppToken;
use app\api\validate\AppTokenGet;
use app\api\service\Token as TokenService;
use app\api\model\Account as AccountModel;
use app\api\validate\UpdatePw;
use app\api\validate\AccountNew;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\AccountPagination;
use app\lib\exception\AccountException;
use app\lib\exception\SuccessMessage;

class Account extends BaseController
{
  protected $beforeActionList = [
      'checkSuperScope' => ['only' => 'getAllStudentInfo']
  ];
    public function getAppToken()
    {
        $validate = new AppTokenGet();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $ac = $dataArray['ac'];
        $pw = $dataArray['pw'];
        $type = $dataArray['type'];
        $app = new AppToken();
        $token = $app->get($ac, $pw, $type);
        return [
            'token' => $token,
            'code' => 20000
        ];
    }

    public function logout()
    {
        $app = new AppToken();
        $app->cleanCacheByToken();
        return new SuccessMessage();
    }
    public function getAllStudentInfo(){
      $validate = new AccountPagination();
      $validate->goCheck();
      $dataArray = $validate->getDataByRule(input('get.'));
      $page = $dataArray['page'];
      $limit = $dataArray['limit'];
      $type=isset($dataArray['type']) ? $dataArray['type'] : 1;
      $name = isset($dataArray['title']) ? '%' . $dataArray['title'] . '%' : '';
      $sex = (!empty($dataArray['sex']) || $dataArray['sex'] == '0') ? $dataArray['sex'] : '0,1';
      $uid=isset($dataArray['uid']) ? '%' . $dataArray['uid'] . '%' : '';
      $labs = AccountModel::all(function ($query) use ($page, $limit, $name, $sex, $uid,$type) {
            $query->where('type',$type)->where('uname', 'like', $name)->where('uid', 'like', $uid)->whereIn('sex', $sex)->page($page, $limit);
      });
      $count = AccountModel::all(function ($query) use ($name, $sex,$uid,$type) {
            $query->where('type',$type)->where('uname', 'like', $name)->where('uid', 'like', $uid)->whereIn('sex', $sex);
      })->count();
      return new SuccessMessage([
          'data' => ['items' => $labs, 'total' => $count]
      ]);
    }
    public function getInfo()
    {
        $uid = TokenService::getCurrentTokenVar('uid');
        $info = AccountModel::get($uid)->visible(['uname', 'scope', 'type']);
        $role[] = $info['type'];
        $name = $info['uname'];
        $scope = $info['scope'];
        return new SuccessMessage([
            'data' => [
                'role' => $role,
                'name' => $name,
                'scope' => $scope
            ]
        ]);
    }

    public function changePassWord()
    {
        $validate = new UpdatePw();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $initpass=$dataArray['initpass'];
        $password=$dataArray['password'];
        $uid = TokenService::getCurrentTokenVar('uid');
        $oPassword = AccountModel::where('uid', $uid)->value('password');
        if ($oPassword !== $initpass) {
            throw new AccountException([
                'msg' => '密码不正确'
            ]);
        }
        AccountModel::where('uid', $uid)->update(['password'=>$password]);
        return new SuccessMessage();
    }

    public function updateAccount($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new AccountNew();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        AccountModel::where('uid', $id)->update($dataArray);
        return new SuccessMessage();
    }
}
