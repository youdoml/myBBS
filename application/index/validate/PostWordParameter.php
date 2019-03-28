<?php
/**
 * 发布留言参数验证
 */
namespace app\index\validate;

class PostWordParameter extends BaseValidate
{
    protected $rule = [
        // 'uid' => 'require|number',
        'content' => 'require'
    ];
}
