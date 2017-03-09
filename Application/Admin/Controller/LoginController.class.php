<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/8
 * Time: 13:54
 */
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
    public function login(){
        //如果有登录请求
        if(IS_POST){
            $User = new UserApi;
        }else{
            //是否登录
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                $this->display('login/login');
            }
        }
    }
}