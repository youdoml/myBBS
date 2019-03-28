<?php
namespace app\index\controller;

use think\Request;
use think\Controller;
use app\index\model\Users;
use app\index\model\Words as WordModel;
use app\index\service\Words as WordsService;


class Index extends Controller
{
    public function index()
    {
        
        // hidden用field代替获取users的数据 model的预加载中有回调则 model调用field会出问题
        // 外键为空的问题
        $data = (new WordsService)->list();

        
        $data and $this->assign('data',$data);
        return $this->fetch();
    }
}
