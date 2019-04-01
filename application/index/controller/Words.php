<?php
/**
 * word数据接口
 * 44200 留留言发表成功
 * 44201 点赞成功
 * 44401 参数错误
 * 44402 系统繁忙
 * 44403 已点赞
 */

namespace app\index\controller;

use app\index\model\Words as WordsModel;
use app\index\model\WordStar;
use app\index\validate\PostWordParameter;
use think\Request;
use think\Session;

class Words extends BaseController
{
    /**
     * 获取word列表
     * @param $page
     * @return response
     */
    function list($page) {
        return $page;
    }
    /**
     * 获取单个word
     * @param $wid 留言id
     */
    public function one($wid)
    {
        return $wid;
    }
    /**
     * 发表留言
     * @param $requst Request
     */
    public function post(Request $request)
    {

        $vResult = (new PostWordParameter)->docheck();

        if (true !== $vResult) {
            return \returnJsonApi($vResult, 'error', 200, [], 44401);
        }

        $session = new Session;
        // dump($session->get('userinfo'));exit;
        $uid = $session->get('userinfo.uid');
        $content = $request->param('content');
        // $uid = 3;
        $model = new WordsModel;
        $qResult = $model->save(['uid' => $uid, 'content' => $content]);

        if (!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 200, [], 44402);

        }
        return \returnJsonApi('发表成功', 'success', 200, [], 44200);

    }
    /**
     * 为留言点赞
     * @param int wid
     */
    public function star($wid)
    {
        if (!WordsModel::getWordByWid($wid)) {
            return \returnJsonApi("没有该留言", 'error', 200, [], 44401);
        }

        // 是否点赞
        $uid = (new Session)->get('userinfo.uid');

        if (WordStar::getStarById($uid, $wid)) {
            return \returnJsonApi("已经点过赞", 'error', 200, [], 44403);
        }
        // 写成事务
        $incScore;
        $incStar = WordsModel::where('wid', $wid)->setInc('star');
        $incStar and $incScore =(new WordStar)->save(['uid' => $uid, 'wid' => $wid]);
        if ($incStar and $incScore) {
            return \returnJsonApi('点赞成功', 'success', 200, [], 44201);
        }
        WordsModel::where('wid', $wid)->setDec('star');
        return returnJsonApi('系统繁忙', 'error', 200, [], 44402);

    }

}
