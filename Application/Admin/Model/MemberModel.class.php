<?php
/**
 * Created by PhpStorm.
 * User: SEELE
 * Date: 2017/3/10
 * Time: 11:25
 */
namespace Admin\Model;
class MemberModel extends BaseModel{
    protected $tableName = 'member';

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function login($uid){
        /* 检测是否在当前应用注册 */
        $user = $this->field(true)->find($uid);
        if(!$user || 1 != $user['status']) {
            $this->error = L('_USERS_DO_NOT_EXIST_OR_HAVE_BEEN_DISABLED_WITH_EXCLAMATION_'); //应用级别禁用
            return false;
        }
//var_dump($user);die();
        //记录行为
//        action_log('user_login', 'member', $uid, $uid);

        /* 登录用户 */
        $this->autoLogin($user);
        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'uid' => $user['uid'],
            'login' => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip' => get_client_ip(1),
            'last_login_role' => $user['last_login_role'],
        );
        $this->save($data);
        //判断角色用户是否审核
        $map['uid'] = $user['uid'];
        $map['role_id'] = $user['last_login_role'];
        $audit = D('UserRole')->where($map)->getField('status');
        //判断角色用户是否审核 end

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['uid'],
            'username'        => $user['nickname'],
            'last_login_time' => $user['last_login_time'],
            'role_id' => $user['last_login_role'],
            'audit' => $audit,
        );

        //保存session信息
        session('user_auth', $auth);
        //保存数字签名，有什么用？
        session('user_auth_sign', data_auth_sign($auth));
    }
}