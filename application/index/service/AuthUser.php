<?php
/**
 * 用户认证业务逻辑
 */
namespace app\index\service;

class AuthUser
{
    /**
     * @param string $password
     * @param string $username
     */
    public static function encodePsw($username, $password)
    {
        $salt = config('secure.salt');

        $enpsw = md5(md5($password . $salt) . $username . $salt);

        return $enpsw;
    }

}
