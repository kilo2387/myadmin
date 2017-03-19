<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/11
 * Time: 22:17
 */
namespace Admin\Controller;
use Think\Controller;
class TestcurlController extends Controller {
    public function testurl(){
        $arr = $_GET;
        $this->ajaxReturn($arr);
    }
}