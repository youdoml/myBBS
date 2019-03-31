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
        $item = [];
        foreach($cmtList as $value) {
            $item['cid'] = $value['cid'];
            $item['uid'] = $value['uid'];
            $item['username'] = $value['users']['username'];
            $item['image'] = $value['users']['image'];
            $item['content'] = $value['content'];
            $item['create_time'] = $value['create_time'];
            $item['star'] = $value['star'];
            if(isset($value['to_cid'])) {
                $to_cid = $value['to_cid'];
                $item['to_username'] = $cmtList[$to_cid]['users']['username'];
            }
            $data[] = $item;
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