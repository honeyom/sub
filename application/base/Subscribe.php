<?php
/**
 *  文件：Subscribe.php
 *  author:daixianhua
 *  时间：2020/7/5-18:06
 */


namespace app\base;


use think\console\Command;
use think\console\Input;
use think\console\Output;

class Subscribe extends Command
{
    protected function configure()
    {
        $this->setName('subscribe')->setDescription('接受订阅消息');
    }
    protected function execute(Input $input, Output $output)
    {
     $redis=new \Redis();
     $redis->pconnect('127.0.0.1',6379);
     $result=$redis->psubscribe(['*'],function ($redis,$channel,$chan,$msg){
        var_dump($chan);
        var_dump($msg);
     });
    }
}