<?php
/**
 * User: makalong
 * Date: 2018/2/4
 * Time: 12:06
 */

namespace app\api\behavior;


class CORS
{
    /*
    跨域请求设置
    */
    public function appInit(&$params){
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Headers:token, Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods:POST,GET,DELETE,PUT');
        if(request()->isOptions()){
            exit();
        }
    }
}
