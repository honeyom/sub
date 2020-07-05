<?php
/**
 *  文件：Pub.php
 *  author:daixianhua
 *  时间：2020/7/5-17:31
 */


namespace app\index\controller;


class Pub
{
        public $redis=1;
        public function __construct()
        {
            $this->redis=new \Redis();
            $this->redis->connect('127.0.0.1',6379);
        }
        public function index(){
            $msg='欢迎来到英雄联盟'.date('Y.m.d H:i:s',time());
            $result=$this->redis->publish('cctv1',$msg);
            var_dump($result);
        }

}