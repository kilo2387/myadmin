<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/8
 * Time: 12:14
 */

namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
    protected function _initialize(){
        // 获取当前用户ID
//        var_dump('wrdfss');die();
        define('UID', is_login());
        if (!UID) {// 还没登录 跳转到登录页面
            $this->redirect('login/login');
        }
    }
    public function login(){
        $this->display();
    }
}