<?php
/**
 *  文件：Sub.php
 *  author:daixianhua
 *  时间：2020/7/5-17:23
 */


namespace app\index\controller;


class Sub
{

    public function index(){
        $redis=new \Redis();
        $redis->pconnect('127.0.0.1',6379);
        $result=$redis->psubscribe(['*'],function ($redis,$channel,$chan,$msg){
            var_dump($chan);
            var_dump($msg);
        });
        var_dump($result);
    }
}