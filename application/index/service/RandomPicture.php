<?php
/**
 * 随机获取默认头像
 */
namespace app\index\service;

class RandomPicture
{
    protected static $picture = [
        'picture.png',
        'image.jpg'
    ];

    public static function picture()
    {
        return self::$picture[rand(0,1)];
    }
}