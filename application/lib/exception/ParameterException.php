<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 22:36
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 200;
    public $msg = '参数错误';
    public $errorCode = 10000;
}
