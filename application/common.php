<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param string status
 */
function returnJsonApi($msg = "success", $status = "success", $code=200, $data=[],$statusCode='')
{
    $return = [];
    $return['status'] = $status;
    $return['msg'] = $msg;

    $data and $return['data'] = $data;
    $statusCode and $return['statusCode'] = $statusCode;
    
    return json($return, $code);
}
