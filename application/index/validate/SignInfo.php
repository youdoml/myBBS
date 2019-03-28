<?php
/**
 * 注册信息验证
 */
namespace app\index\validate;

class SignInfo extends BaseValidate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'confirm|确定密码' => 'require',
        'email|邮箱地址' => 'require|email',
    ];
}