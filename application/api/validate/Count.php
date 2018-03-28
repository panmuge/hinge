<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30
 * Time: 21:27
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        "count"=>"isPositiveInteger|between:1,20"
    ];
}