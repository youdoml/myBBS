<?php
/**
 * 
 */
namespace app\index\controller;

use app\index\model\Users;
use app\index\model\Words;
use app\index\model\Comments;

class Demo
{
    function index()
    {
        dump(Words::with('comments')->field('wid, content')->get(2));
    }
}