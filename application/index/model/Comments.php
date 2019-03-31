<?php
/**
 * 留言评论模型
 */
namespace app\index\model;

class Comments extends BaseModel
{

    protected $pk = 'cid';

    protected $autoWriteTimestamp = true;

    protected $updateTime = false;
    
    // 关联Users
    public function users()
    {
        return $this->belongsTo('Users', 'uid');
    }
    // 关联Words
    public function words()
    {
        return $this->belongsTo('Words', 'wid');
    }

    /**
     * 通过cid 获取评论
     * @param number cid
     * @return mixed
     */
    public static function getCommentByCid($cid)
    {
        return Comments::get($cid);
    }

}