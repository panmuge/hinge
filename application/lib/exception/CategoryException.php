<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */

namespace app\lib\exception;


class CategoryException extends  BaseException
{
    public $code = 500;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode = 50000;
}