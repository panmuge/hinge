<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/04/08
 * Time: 18:01
 */

namespace app\admin\validate;

class BannerItems extends BaseValidate
{
    protected $rule = [
        "id" => "require|isPositiveInteger",
        "img_id" => "require|isPositiveInteger",
        "type" => "require|isPositiveInteger",
        "key_word" => "require|isPositiveInteger",
    ];

    protected $message = [
        'id'=>'id必须是正整数',
        'img_id'=>'img_id必须是正整数',
        'type'=>'type必须是正整数',
        'key_word'=>'key_word必须是正整数',
    ];

}