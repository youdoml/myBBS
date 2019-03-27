<?php
/**
 * 留言评论模型
 */
namespace app\index\model;

use think\Model;

class Commment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $pk = 'cid';
}