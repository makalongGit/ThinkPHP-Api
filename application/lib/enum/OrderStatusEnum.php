<?php
/**
 * User: makalong
 * Date: 2018/3/10
 * Time: 1:49
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const AUDIT = 0;//审核中
    const PASS = 1;   //审核通过
    const FAIL = 2;   //审核失败
    const INVALID = 3;//无效
}