<?php
/**
 * 用户注册
 */
namespace app\index\controller;

use app\index\model\Users;
use app\index\service\AuthUser;
use app\index\validate\SignInfo;
use think\Request;

class Register extends BaseController
{
    /**
     * 返回注册页面
     */
    public function index()
    {
        return $this->fecth();
    }
    /**
     * 注册用户
     * 77200 chneg
     * 77401 yizhuce
     * 77402 验证错误
     * 77403 系统繁忙
     */
    public function sign(Request $request)
    {

        $vResult = (new SignInfo)->docheck();
        if (true !== $vResult) {
            return \returnJsonApi($vResult, 'error', 200, [], 77402);
        }

        $data = $request->param();
        $username = $data['username'];
        if (Users::getUserByUsername($username)) {
            return \returnJsonApi('用户名被注册','error', 200, [], 77401);
        }

        if ($data['password'] !== $data['confirm']) {
            return \returnJsonApi('两次密码输入不一致', 'error', 200, [], 77402);
        }

        // 注册信息入库
        $data['password'] = AuthUser::encodePSW($username, $data['password']);

        $users = new Users;
        $qResult = $users->allowField(['username', 'password', 'email'])->save($data);

        if (!$qResult) {
            return \returnJsonApi('系统繁忙', 'error', 200, [], 77403);
        }

        return \returnJsonApi('注册成功', 'success', 200, ['url' => url('index/index/index')], 77200);

    }
    /**
     * 验证email
     */
    public function checkEmail()
    {

    }

}
