<?php
/**
 * 用户模型
 */
namespace app\index\model;

class Users extends BaseModel
{
    
    protected $pk = 'uid';

    protected $autoWriteTimestamp = true;

    protected $updateTime = false;

    public function words()
    {
        return $this->hasMany('Words', 'uid');
    }

    /**
     * 根据uid获取用户
     * @param string $useranme
     * @return Users
     */
    public static function getUserByUsername($username)
    {
        $user = Users::where('username', $username)->find();
        return $user;
    }
}