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
        echo 'wer';
    }
    public function test(){
        echo 'dfw';
    }
}