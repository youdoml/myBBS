<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('bbs', function () {
    return 'welcome here -- MyBBS!';
});

Route::get('hello/:name', 'index/hello');

// 主页
Route::get('home', 'index/index/index');
// word接口
Route::get('list/:page', 'index/Words/list')->pattern(['page' => '\d+']);
Route::get('word/:wid$', 'index/Words/one')->pattern(['wid' => '\d+']);
Route::rule('post/word', 'index/words/post', 'GET|POST')->middleware('Auth');
// 评论接口路由
Route::get('comments/:wid', 'index/comments/list')->pattern(['wid' => '\d+']);
Route::rule('post/comment', 'index/comments/post', 'GET|POST')->middleware('Auth');

Route::get('login', 'index/index/sign');
Route::get('register', 'index/index/register');

Route::get('user/exit', 'index/login/off')->middleware('Auth');
Route::rule('sign/in', 'index/login/on');
Route::rule('sign/up', 'index/register/sign');

