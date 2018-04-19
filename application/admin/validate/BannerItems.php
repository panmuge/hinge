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
        "banner_id" => "require|isPositiveInteger",
        "type" => "require|isPositiveInteger",
        "key_word" => "require|isPositiveInteger",
    ];

    protected $message = [
        'banner_id'=>'banner_id必须是正整数',
        'type'=>'type必须是正整数',
        'key_word'=>'key_word必须是正整数',
    ];

}