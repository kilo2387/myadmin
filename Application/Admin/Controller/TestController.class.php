<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/11
 * Time: 22:10
 */

namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller{
    public $_ch;
    public function test(){
//        $url = 'http://www.jkl.com:8003/OcApi/oc.php?code=MDAwMDAwMDAwMJG6hpKau5zag46LoMRjtaacrdGmirWWr4CqymWzmn-Uhd2jlA';
        $url = 'http://localhost:8003/OcApi/oc.php?code=MDAwMDAwMDAwMJG6hpKau5zag46LoMRjtaacrdGmirWWr4CqymWzmn-Uhd2jlA';
        $this->_ch = curl_init();
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_TIMEOUT,120);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//302redirect
//        curl_setopt($ch, CURLOPT_POST, true);//使用post方式
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);//信任https证书
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_TIMEOUT, 130 );
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, false );
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //执行并获取HTML文档内容
        $output = curl_exec($this->_ch);
        var_dump(curl_error($this->_ch));
        $dd = curl_getinfo($output);
        //释放curl句柄
        curl_close($this->_ch);
        var_dump($output, $dd);

    }
}