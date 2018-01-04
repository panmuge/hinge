<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 23:26
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule=[
        'ids'=>'require|checkIDs'
    ];

    protected $message = [
        'ids'=>'ids必须是以逗号分隔的正整数'
    ];

    protected function checkIDs($value){
        $value = explode(",",$value);
        if(empty($value)){
            return false;
        }
        foreach ($value as $ids){
            if(!$this->isPositiveInteger($ids)){
                return false;
            }
        }
        return true;
    }
}