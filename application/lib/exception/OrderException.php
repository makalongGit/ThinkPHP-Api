<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 0:55
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 200;
    public $msg = '预约ID不存在，请检查ID';
    public $errorCode = 20000;
}
