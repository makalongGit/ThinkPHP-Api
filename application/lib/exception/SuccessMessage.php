<?php
/**
 * User: makalong
 * Date: 2018/2/5
 * Time: 22:24
 */

namespace app\lib\exception;


class SuccessMessage
{
    public $code = 20000;
    public $data =[];
    function __construct($params=[]){
      if (!is_array($params)) {
          return;
      }
      if (array_key_exists('code', $params)) {
          $this->code = $params['code'];
      }
      if(array_key_exists('data', $params)){
        $this->data=$params['data'];
      }
    }
}
