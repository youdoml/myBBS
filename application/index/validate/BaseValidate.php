<?php
/**
 * 自定义验证基类
 */
namespace app\index\validate;

use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 提交数据验证
     * @return bool true| string
     */
    public function docheck()
    {
        $data = request()->param();

        if(!$this->batch(true)->check($data)) {
            // 返回验证错误信息
            return (is_array($this->error) ? implode('|', $this->error) : $this->error);
        }
        return true;
    }
}