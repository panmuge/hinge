<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 12:19
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden =['id', 'delete_time', 'user_id'];
}