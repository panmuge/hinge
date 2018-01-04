<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 11:48
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getOneUser($openid,$field='openid'){
        return self::field($field)->where('openid','=',$openid)->find();
    }
}