<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 21:20
 */

namespace app\lib\exception;


class ParameterException extends BaseException{
	public $code = 400;
	public $msg = '参数错误';
	public $errorCode = 10000;
}
