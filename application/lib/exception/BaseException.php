<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */
namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception{
	public $code = 400;
	public $msg = '参数错误';
	public $errorCode = 10000;
	function __construct($params =[])
	{
		if (!is_array($params)) {
			// throw new Exception('参数必须是数组');
			return;
		}
		if (array_key_exists('code', $params)) {
			$this->code = $params['code'];
		}
		if (array_key_exists('msg', $params)) {
			$this->msg = $params['msg'];
		}
		if (array_key_exists('errorCode', $params)) {
			$this->errorCode = $params['errorCode'];
		}
	}
}