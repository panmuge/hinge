<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 22:33
 */

namespace app\api\model;


class ProductImage extends BaseModel
{

    protected $hidden = ['id','img_id','product_id'];


    public function img(){
        $imgurl = $this->belongsTo('image','img_id','id')->field("id,url,from");
        return $imgurl;
    }
}