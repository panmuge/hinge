<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //获取图片前缀url公共方法
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if($data['from']==1){
            $finalUrl = config("seting.img_prefix").$value;
        }
        return $finalUrl;
    }
}
