<?php
/**
 *  文件：Test.php
 *  author:daixianhua
 *  时间：2020/7/5-15:34
 */
namespace behavior;

use think\facade\Log;
use think\facade\Request;

class Test
{

    public function start(){
        Log::debug(date('Y:m:d H:i:s',time()).'写入了日志::'.Request::controller().'/'.Request::action());
    }
}