<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19
 * Time: 23:47
 */

namespace app\lib\exception;



class BannerMissException extends BaseException
{
    public $code = "404";
    public $msg = "请求Banner不存在";
    public $errorCode = 40000;
}