<?php

namespace app\api\model;

class Image extends BaseModel
{
    protected $hidden = ['id','from'];
    //读取器 get 加 首字符大写字段名 加 Attr
    protected function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
}
