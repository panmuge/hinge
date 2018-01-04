<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30
 * Time: 23:12
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 400;
    public $msg = "指定类目不存在，请检查参数";
    public $errorCode = 50000;
}