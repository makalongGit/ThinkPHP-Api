<?php
/**
 * User: makalong
 * Date: 2018/2/3
 * Time: 12:56
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    //验证基础权限
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }

    protected function checkSuperScope(){
        TokenService::needSuperScope();
    }
}
