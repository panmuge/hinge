<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */


namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 400;
    public $msg = '指定的商品不存在，请检查参数';
    public $errorCode = 20000;
}