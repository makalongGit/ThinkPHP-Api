<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 12:25
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 200;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 50014;
}
