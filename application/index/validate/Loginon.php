<?php
/**
 * 登录验证器
 */
namespace app\index\validate;

class Loginon extends BaseValidate
{
    protected $rule = [
        "username|用户名" => 'require',
        "password|密码" => 'require',
        // "validate" => 'require'
    ];
}