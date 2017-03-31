<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
<<<<<<< HEAD
        $this->display();
=======
<<<<<<< HEAD
        $this->show('welcome');
=======
//        var_dump(session('user_auth'), session('user_auth_sign'));
        session('user_auth', null);
        $this->display('index/index');
>>>>>>> dc00bc8... none
>>>>>>> 69cdb90674a2c52046cf430616075d5ad0b63b39
    }
}