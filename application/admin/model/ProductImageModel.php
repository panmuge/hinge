<?php

namespace app\admin\model;

use think\Model;

class ProductImageModel extends BaseModel
{
    //表名称
    protected $table = "product_image";
    //关联image model
    public function image(){
        return $this->hasOne("ImageModel","img_id","id")->field("id,url,from");
    }
}