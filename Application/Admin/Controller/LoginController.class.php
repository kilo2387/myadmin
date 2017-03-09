<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/8
 * Time: 13:54
 */
namespace Admin\Controller;
use Think\Controller;
use User\Api\UserApi;
class LoginController extends Controller{
    public function login($user_name = null, $time_password = null){
        $username = $user_name;
        $password = $time_password;
        //如果有登录请求
        if(IS_POST){
            $user = new UserApi();
//            var_dump($username);
            $u_id = $user->login($username, $password);
            if($u_id > 0){
                $this->redirect('Index/index');
            }
//            var_dump($data);die();

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