<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 11:18
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;
use think\captcha\Captcha;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取http传过来的参数，并进行校验
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value) && $value != 0) {
            return false;
        } else {
            return true;
        }
    }

    protected function check_verify($code, $id = '')
    {
        $captcha = new Captcha();
        return $captcha->check($code, $id);
    }
    protected  function checkPhone($value, $rule = '', $data = '', $field = ''){

    }

    public function getDataByRule($arrays)
    {
        // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
        // if (array_key_exists('user_id', $arrays) || array_key_exists('uid', $arrays)) {
        //     throw new ParameterException([
        //         'msg' => '参数中包含有非法的参数名user_id或者uid'
        //     ]);
        // }
        $newArray = array();
        foreach ($this->rule as $k => $v) {
            $newArray[$k] = $arrays[$k];
        }
        return $newArray;
    }
}
