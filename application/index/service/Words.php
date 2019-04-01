<?php
/**
 * 
 */
namespace app\index\service;

use app\index\service\Comments;
use app\index\model\Words as WordsModel;

class Words
{
    public function list($number=10, $page=1)
    {
        $data = WordsModel::with(['users' => function($query){
            $query->field('username, uid, image');
        }, 'comments' => function($query){
            $query->with(['users' => function($query){
                $query->field('username, uid, image, create_time');
            }])->hidden(['delete_time']);
        }])->hidden(['delete_time'])->limit(10)->order('wid', 'desc')->all()->toArray();

        // dump($data);exit;->order('wid', 'desc')
        if($data) {
            foreach($data as $k => $v) {
                // 整合评论数据
                $comments = Comments::dealCmtList($v['comments']);
                $data[$k]['comments'] = $comments;
            };
        }
        
        // dump($data);exit;
        // 整合信息
        
        // dump($data[1]);exit;
        return $data;
    }
}