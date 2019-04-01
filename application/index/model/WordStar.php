<?php
/**
 * 留言点赞模型
 */
namespace app\index\model;

class WordStar extends BaseModel
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    /**
     * 根据uid cid 查询点赞
     */
    public static function getStarById($uid, $wid)
    {
        return WordStar::get(['uid' => $uid, 'wid' => $wid]);
    }
}