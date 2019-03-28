<?php
/**
 * word数据接口
 */

namespace app\index\controller;

use think\Request;
use think\Session;
use app\index\model\Words as WordsModel;
use app\index\validate\PostWordParameter;

class Words extends BaseController
{
    /**
     * 获取word列表
     * @param $page
     * @return response
     */
    public function list($page)
    {
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
        $return = array();
        $vResult = (new PostWordParameter)->docheck();
        
        if (true !== $vResult) {
            $return['status'] = 'error';
            $return['msg'] = $vResult;
            return json($return)->code(400);
        }

        $session = new Session;
        // dump($session->get('userinfo'));exit;
        $uid = $session->get('userinfo.uid');
        $content = $request->param('content');
        // $uid = 3;
        $model = new WordsModel;
        $qResult = $model->save(['uid' => $uid, 'content' => $content]);

        if(!$qResult) {
            $return['msg'] = '系统繁忙';
            $return['status'] = 'error';

            return json($return)->json(400);
        } 

        $return['msg'] = '发表成功';
        $return['status'] = 'success';
        
        return json($return);

    }
}
