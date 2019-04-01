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

        if(!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 200, [], 44402);
            
        } 
        return \returnJsonApi('发表成功', 'success', 200, [], 44200);

    }
}
