<?php
/**
 * User: makalong
 * Date: 2018/2/11
 * Time: 22:36
 */

namespace app\lib\exception;


class RepairException extends BaseException
{
    public $code = 500;
    public $msg = '指定的信息不存在，请检查参数';
    public $errorCode = 50000;
}
