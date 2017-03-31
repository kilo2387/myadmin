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
//        var_dump(is_api_login());die();
        return is_api_login();
    }

//    print_r(function_exists('I_POST'));die('w');
    $user = session('user_auth');
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
//UC_CONNECT
function uc_user_login($username, $password, $isuid = 0, $checkques = 0, $questionid = '', $answer = '') {
    $isuid = intval($isuid);
    $return = call_user_func('mysql', 'user', 'login', array('username'=>$username, 'password'=>$password, 'isuid'=>$isuid, 'checkques'=>$checkques, 'questionid'=>$questionid, 'answer'=>$answer));
    return 'mysql' == 'mysql' ? $return : uc_unserialize($return);
}

/**
 * 根据用户ID获取用户名
 * @param  integer $uid 用户ID
 * @return string       用户名
 */
function get_username($uid = 0)
{
    static $list;
    if (!($uid && is_numeric($uid))) { //获取当前登录用户名
        return $_SESSION['ocenter']['user_auth']['username'];
    }

    /* 获取缓存数据 */
    if (empty($list)) {
        $list = S('sys_active_user_list');
    }

    /* 查找用户信息 */
    $key = "u{$uid}";
    if (isset($list[$key])) { //已缓存，直接使用
        $name = $list[$key];
    } else { //调用接口获取用户信息
        $User = new User\Api\UserApi();
        $info = $User->info($uid);
        if ($info && isset($info[1])) {
            $name = $list[$key] = $info[1];
            /* 缓存用户 */
            $count = count($list);
            $max = C('USER_MAX_CACHE');
            while ($count-- > $max) {
                array_shift($list);
            }
            S('sys_active_user_list', $list);
        } else {
            $name = '';
        }
    }
    return $name;
}

/**
 * 根据时间戳，计算周几
 * @author liwei 2015.12.18
 * @param string $data 时间戳
 * @param string $format 格式，默认：周
 * @return string 格式后的数据
 */
function getWeekName($data, $format = '周') {
    $week = date('D', $data);
    switch ($week) {
        case 'Mon':
            $current = $format.'一';
            break;
        case 'Tue':
            $current = $format.'二';
            break;
        case 'Wed':
            $current = $format.'三';
            break;
        case 'Thu':
            $current = $format.'四';
            break;
        case 'Fri':
            $current = $format.'五';
            break;
        case 'Sat':
            $current = $format.'六';
            break;
        case 'Sun':
            $current = $format.'日';
            break;
    }
    return $current;
}

/**
 * 数据签名认证
 * @param  array $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data)
{
    //数据类型检测
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 */
if (!defined('USER_COMMON_COMMON_PHP')) {
    function think_ucenter_md5($str, $key = 'ThinkUCenter')
    {
        return '' === $str ? '' : md5(sha1($str) . $key);
    }

    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key 加密密钥
     * @param int $expire 过期时间 (单位:秒)
     * @return string
     */
    function think_ucenter_encrypt($data, $key, $expire = 0)
    {
        $key = md5($key);
        $data = base64_encode($data);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }
        $str = sprintf('%010d', $expire ? $expire + time() : 0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
        }
        return str_replace('=', '', base64_encode($str));
    }

    /**
     * 系统解密方法
     * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
     * @param string $key 加密密钥
     * @return string
     */
    function think_ucenter_decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data = substr($data, 10);
        if ($expire > 0 && $expire < time()) {
            return '';
        }
        $len = strlen($data);
        $l = strlen($key);
        $char = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }
}

//防止重复定义
define('USER_COMMON_COMMON_PHP', 1);