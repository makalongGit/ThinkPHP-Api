<?php
/**
 * User: makalong
 * Date: 2018/3/14
 * Time: 10:13
 */

namespace app\lib\exception;


class DeviceException extends  BaseException
{
    public $code = 500;
    public $msg = '指定的信息不存在，请检查参数';
    public $errorCode = 60000;
}