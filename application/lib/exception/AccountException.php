<?php
/**
 * User: makalong
 * Date: 2018/2/7
 * Time: 11:22
 */

namespace app\lib\exception;


class AccountException extends BaseException
{
    public $code=404;
    public $msg='用户不存在';
}