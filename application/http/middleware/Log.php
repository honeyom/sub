<?php

namespace app\http\middleware;

use behavior\Test;
use think\facade\Hook;

class Log
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // 添加中间件执行代码
        $params="啊啊啊我是钩子,我写入了日志";
        $hook=new Hook();
        $hook::add('start',Test::class);
        $hook::listen('start',$params);
        return $response;
    }
}
