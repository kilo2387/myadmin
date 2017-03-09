<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/9
 * Time: 16:52
 */

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login()
{
    if(is_api_login()){
        return is_api_login();
    }

//    print_r(function_exists('I_POST'));die('w');
    $user = session('user_auth');
//    var_dump($user);die();
    if (empty($user)) {
        return  0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
    }
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