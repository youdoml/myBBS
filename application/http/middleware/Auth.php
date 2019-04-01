<?php
/**
 * 用户判断是否登录
 */
namespace app\http\middleware;

use think\Session;

class Auth 
{
    public function handle($request, \Closure $next)
    {
        if(!(new Session)->has("userinfo")) {
           
            return \returnJsonApi("未登录",'error', 200,array('location'=>url("index/index/sign")), 11401);
        }
        return $next($request);
    }
}