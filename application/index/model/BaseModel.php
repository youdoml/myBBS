<?php
/**
 * 自定义Model基类
 */
namespace app\index\model;

use think\Model;
use think\model\concern\SoftDelete;

class BaseModel extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    

    protected $hidden = [ 'delete_time'];
}