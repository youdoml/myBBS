<?php
/**
 * 评论点赞的模型
 */
namespace app\index\model;


class CommentStar extends BaseModel
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    
    /**
     * 通过cid uid获取点赞的记录
     * @param int cid 
     * @param uid
     * @return mixed
     */
    public static function getStarById($uid, $cid)
    {
        return CommentStar::get(['cid' => $cid, 'uid' => $uid]);
    }
}
