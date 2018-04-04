<?php
/**
 * User: makalong
 * Date: 2018/2/3
 * Time: 19:06
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 500;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode = 50000;
}