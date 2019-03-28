<?php
/**
 * 
 */
namespace app\index\service;

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
        }])->hidden(['delete_time'])->limit(10)->all()->toArray();

        if(!$data) {
            return false;
        }
        // dump($data);exit;
        // comments{cid content delete_time uid cuname to_uname image}
        // key = cid处理
        $data = array_map(function($value){
            $comments = [];
            foreach( $value['comments'] as $val){
                $comments[$val['cid']] = $val;
            }
            $value['comments'] = $comments;
            return $value;
            
        }, $data);
        // dump($data);exit;
        // 整合信息
        foreach($data as $k => $v) {
            $comments = [];
            foreach($v['comments'] as $key => $value) {
                
                $comments[$key]['cid'] = $value['cid'];
                // $comments[$key]['uid'] = $value['uid'];
                $comments[$key]['username'] = $value['users']['username'];
                $comments[$key]['image'] = $value['users']['image'];
                $comments[$key]['content'] = $value['content'];
                $comments[$key]['create_time'] = $value['create_time'];
                $comments[$key]['star'] = $value['star'];
                if(isset($value['to_cid'])) {
                    $to_cid = $value['to_cid'];
                    $comments[$key]['to_username'] = $v['comments'][$to_cid]['users']['username'];
                }
            }
            $data[$k]['comments'] = $comments;
        }
    
        return $data;
    }
}