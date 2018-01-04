<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 15:35
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        //随机字符串
        $randChars = getRandChar(32);
        //访问时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
}