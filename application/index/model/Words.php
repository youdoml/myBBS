<?php
/**
 * 留言模型
 */
namespace app\index\model;


class Words extends BaseModel
{

    protected $pk = 'wid';

    protected $autoWriteTimestamp = true;

    protected $updateTime = false;

    // public function getCreateTimeAttr($value)
    // {
    //     // return date('Y-m-d', $value);
    // }
    public function comments()
    {
        return $this->hasMany('Comments', 'wid');
    }

    public function users()
    {
        return $this->belongsTo('Users', 'uid');
    }
}