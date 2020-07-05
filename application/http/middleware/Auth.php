<?php

namespace app\http\middleware;

class Auth
{
    /***
     * @param $request 前置中间件，验证登陆
     * @param \Closure $next
     * @return mixed|\think\response\Redirect
     */
    public function handle($request, \Closure $next)
    {

        //中间件处理如果没有登陆
        if (empty(session(config('admin.session_admin'))) && !preg_match('/login', $request->pathinfo())) {
            return redirect(url('login/index'));
        }
        return next($request);
    }
}
