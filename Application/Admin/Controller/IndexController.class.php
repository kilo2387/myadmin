<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
<<<<<<< HEAD
        $this->show('welcome');
=======
//        var_dump(session('user_auth'), session('user_auth_sign'));
        session('user_auth', null);
        $this->display();
>>>>>>> aaa7de9... behavior
    }
}