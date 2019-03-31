<?php
/**
 * 用户登录
 * code [
 *  66201 登录成功
 *  66401 已经登录
 *  66402 参数错误
 *  66403 
 *  66404 用户密码错误
 * ]
 */
namespace app\index\controller;

use think\Request;
use think\Session;
use app\index\model\Users;
use app\index\service\AuthUser;
use app\index\validate\Loginon;

class Login extends BaseController
{
    /**
     * 登录
     *
     */
    public function on(Request $request)
    {
        $session = new Session;
        if ($session->has('userinfo')) {
            // TODO: 已登录处理
        }

        $vResult = (new Loginon)->docheck();
        if($vResult !== true) {
            // TODO: 提交数据错误
            return;
        }

        $data = $request->param();
        // TODO:验证码

        // 验证用户密码
        $username = $data['username'];
        $password = AuthUser::encodePSW($username, $data['password']);
        $qResult = Users::where(['username' => $username, 'password' => $password])->field('uid,email, image')->find();

        if(!$qResult) {
            $return['msg'] = '账号或密码错误';
            $return['status'] = 'error';
            return $this->success('登录成功',url("index/index/index"));
            // $return['statusCode'] = 
            return json($return)->code(400);
        }

        //用户的信息
        $uid = $qResult['uid'];
        $email = $qResult['email'];
        $image = $qResult['image'];
        // TODO: 扩展功能--登录ip、登录时间记录

        // 设置登录状态
        $session->set('userinfo.username', $username);
        $session->set('userinfo.uid', $uid);
        $session->set('userinfo.email', $email);
        $session->set('userinfo.image', $image);

        // 前端进行跳转逻辑
        $return['url'] = url('index/index/index');
        $return['status'] = 'success';
        // $return['statusCode'] = 
        $return['msg'] = '登录成功';
        
        return json($return)->code(200);

    }
    /**
     * 生成验证码
     */
    public function createCode()
    {
        
    }
    
    /**
     * 安全退出
     */
    public function off()
    {
        return json((new Session)->pull('userinfo'));
    }
}
