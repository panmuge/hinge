<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/17
 * Time: 22:01
 */
namespace app\api\validate;

class IDMustBePostiveInt extends BaseValidate{


	protected $rule = [
					'id' => 'require|isPositiveInteger'
				];
	protected $message = [
		'id' => 'id必须是正整数'
	];
}