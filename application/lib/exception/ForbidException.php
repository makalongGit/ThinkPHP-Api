<?php
/**
 * User: makalong
 * Date: 2018/3/26
 * Time: 17:14
 */

namespace app\lib\exception;


class ForbidException extends BaseException
{
    public $code = 500;
    public $msg = '权限不够';
    public $errorCode = 50000;
}