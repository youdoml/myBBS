<?php
/**
 * 评论接口
 */
namespace app\index\controller;

use think\Request;
use app\index\model\Words;
use app\index\model\CommentStar;
use app\index\validate\PostCommentParameter;
use app\index\model\Comments as CommentsModel;
use app\index\service\Comments as CommentsService;


class Comments extends BaseController
{
    /**
     * 获取评论的列表
     * @param int $wid 留言的id
     */
    public function list($wid)
    {
        $return = [];
        // 判断wid是否存在
        if(!Words::getWordByWid($wid)){
            $return['status'] = 'error';
            $return["msg"] = '参数无效';
            return json($return, 400);
        }

        $qResult = CommentsModel::where('wid', $wid)->order('cid', 'asc')->with(['users' => function($query){
            $query->field('username, image,uid');
        }])->hidden(['delete_time'])->all();
        // dump($qResult);
        if(!$qResult) {
            $return['status'] ='error';
            $return['msg'] = '系统错误';
            return json($return, 500);
        }

        // 整合评论数据
        $data['list'] = CommentsService::dealCmtList($qResult);
        $data['img_path'] = config('template.tpl_replace_string.__UPLOAD__') . 'images/';
        // dump($data['img_path']);
        $return['status'] = 'success';
        $return['msg'] = '获取数据成功';
        $return['data'] = $data;
        return json($return, 200);
    }
    /**
     * 进行评论
     * @param Request $request
     */
    public function post(Request $request)
    {
        
        $vResult = (new PostCommentParameter)->docheck();
        if(true !== $vResult) {
            return \returnJsonApi($vResult, 'error', 400);
        }

        $data = $request->param();
        $data['uid'] = 2;
        $qResult = (new CommentsModel)->allowField(true)->save($data);

        if(!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 400);
        }
        // return json($request->param())->code(500);
        return \returnJsonApi('评论成功', 'success', 200);

    }
    /**
     * 评论的点赞功能
     * @param int cid 评论的编号
     * @return Response
     */
    public function star($cid) {

        if(CommentsModel::getCommentByCid($cid))
        {
            return \returnJsonApi("没有该评论", 'error', 400);
        }

        // TODO: 是否点赞
        // $uid = 
        // if (CommentStar::getStarById($uid, $cid)){
        //     return \returnJsonApi("已经点过赞", 'error', 400);
        // }
        
        
        
        
    }
}