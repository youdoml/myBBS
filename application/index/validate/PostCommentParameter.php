<?php
/**
 * comment 数据校验
 */
namespace app\index\validate;

class PostCommentParameter extends BaseValidate
{
    protected $rule = [
        "wid" => "require|number",
        "cid"   => "number",
        "content" => "require",
    ];
}