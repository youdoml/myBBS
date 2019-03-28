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
     */
    public function sign(Request $request)
    {
        // 返回数据
        $return = array();

        $vResult = (new SignInfo)->docheck();
        if (true !== $vResult) {
            // TODO: 验证错误处理
            return json($vResult);
        }

        $data = $request->param();
        $username = $data['username'];
        if (Users::getUserByUsername($username)) {
            $return['status'] = 'error';
            $return['msg'] = '用户名已被注册';
            // $return['statusCode'] =
            return json($return)->code(400);
        }

        if ($data['password'] !== $data['confirm']) {
            $return['status'] = 'error';
            $return['msg'] = '两次输入的密码不一致';
            // $return['statusCode'] =
            return json($return)->code(400);
        }

        // 注册信息入库
        $data['password'] = AuthUser::encodePSW($username, $data['password']);

        $users = new Users;
        $qResult = $users->allowField(['username', 'password', 'email'])->save($data);

        if (!$qResult) {
            $return['status'] = 'success';
            $reutrn['msg'] = '注册成功';
            // $return['statusCode'] =
            return json($return)->code(200);
        }

    }
    /**
     * 验证email
     */
    public function checkEmail()
    {

    }

}
