<?php

namespace app\admin\model;

use think\Model;

class ImageModel extends BaseModel
{
    //表名称
    protected $table = "image";

    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

}