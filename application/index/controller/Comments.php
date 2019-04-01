<?php
/**
 * 评论接口
 */
namespace app\index\controller;

use think\Request;
use think\Session;
use app\index\model\Words;
use app\index\model\CommentStar;
use app\index\validate\PostCommentParameter;
use app\index\model\Comments as CommentsModel;
use app\index\service\Comments as CommentsService;

/**
 * 接口状态吗
 * 33200 发表成功
 * 33201 查成功
 * 33202 点赞成功
 * 33401 参数无效
 * 33402 系统繁忙
 * 33403 已点赞
 * 
 */

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
            return \returnJsonApi('没有该贴文', 'error', 200, [], 33401);
        }

        $qResult = CommentsModel::where('wid', $wid)->order('cid', 'asc')->with(['users' => function($query){
            $query->field('username, image,uid');
        }])->hidden(['delete_time'])->all();
        // dump($qResult);
        if(!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 200, [], 33402);
        }

        // 整合评论数据
        $data['list'] = CommentsService::dealCmtList($qResult);
        $data['img_path'] = config('template.tpl_replace_string.__UPLOAD__') . 'images/';
        $data["starUrl"] = url('/star/comment');
        // dump($data['img_path']);
        
        return \returnJsonApi('获取成功', 'success', 200, $data, 33201);
    }
    /**
     * 进行评论
     * @param Request $request
     */
    public function post(Request $request)
    {
        
        $vResult = (new PostCommentParameter)->docheck();
        if(true !== $vResult) {
            return \returnJsonApi($vResult, 'error', 200, [], 33401);
        }

        $uid = (new Session)->get('userinfo.uid');

        $data = $request->param();
        $data['uid'] = $uid;
        $qResult = (new CommentsModel)->allowField(true)->save($data);

        if(!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 200, [], 33402);
        }
        // return json($request->param())->code(500);
        return \returnJsonApi('评论成功', 'success', 200, [], 33200);

    }
    /**
     * 评论的点赞功能
     * @param int cid 评论的编号
     * @return Response
     */
    public function star($cid) {
        $cid = intval($cid);


        if(!CommentsModel::getCommentByCid($cid))
        {
            return \returnJsonApi("没有该评论", 'error', 200, [], 33401);
        }

        // TODO: 是否点赞
        // 获取用户id
        $uid = (new Session)->get('userinfo.uid');

        if ($r = CommentStar::getStarById($uid, $cid)){
            return \returnJsonApi("已经点过赞", 'error', 200, [], 33403);
        }
        
        // TODO: 写成事务
        $incScore;
        $incStar = CommentsModel::where('cid', $cid)->setInc('star');
        $incStar and $incScore = (new CommentStar)->save(['uid' => $uid, 'cid' => $cid]);
        if ($incStar and $incScore) {
            return \returnJsonApi('点赞成功', 'success', 200, [], 33202);
        }
        return returnJsonApi('系统繁忙', 'error', 200, [], 33402);

    }
}