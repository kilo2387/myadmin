<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/8
 * Time: 18:00
 */
namespace app\demo\logic;
class Func{
    /**
     * 判断是否登录函数
     */
    public function is_login(){
        $user = session('is_login');
        if(empty($user)){
            return false;
        }
        return $user;
    }

    /* 1、这是不是检查是不是子系统的登录 */
    function is_api_login()
    {
        if(function_exists('I_POST')){
            $user =R('Api/Base/isLogin');
            if (empty($user)) {
                return 0;
            } else {
                return  $user;
            }
        }else{
            return 0;
        }
    }
}