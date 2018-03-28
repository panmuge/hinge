<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 11:33
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule=[
        'code'=>'require|isNotEmpty'
    ];

    protected $message=[
        'code'=>'code不存在'
    ];
}