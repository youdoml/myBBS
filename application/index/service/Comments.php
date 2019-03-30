<?php
/**
 * comment
 */
namespace app\index\service;

class Comments 
{
    /**
     * 处理获取的comments获取数据 
     * @param array $cmtList
     * @return array 
     */
    public static function dealCmtList($cmtList)
    { 
        // 将cid作为数组索引
        $cmtList = self::cidToIndex($cmtList);

        $data = [];
        foreach($cmtList as $key => $value) {
            $data[$key]['cid'] = $value['cid'];
            $data[$key]['uid'] = $value['uid'];
            $data[$key]['username'] = $value['users']['username'];
            $data[$key]['image'] = $value['users']['image'];
            $data[$key]['content'] = $value['content'];
            $data[$key]['create_time'] = $value['create_time'];
            $data[$key]['star'] = $value['star'];
            if(isset($value['to_cid'])) {
                $to_cid = $value['to_cid'];
                $data[$key]['to_username'] = $cmtList[$to_cid]['users']['username'];
            }
        }
        // dump($data);exit;
        return $data;

    }
    /**
     * 将数组的索引值变为cid
     * @param array $list
     * @return array
     */
    public static function cidTOIndex($list)
    {
        $data = array();
        foreach($list as $item){
            $data[$item['cid']] = $item;
        }
        return $data;
    }
}