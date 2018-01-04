<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = ['img_id','pivot','from'];


    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public static function getMostRecent($count){
        return self::field('id,name,price,stock,category_id,main_img_url,from,img_id')->limit($count)->order('create_time desc')->select();
    }

    public static function getProductByCategoryID($category_id)
    {
        $products = self::field('id,name,price,stock,category_id,main_img_url,from,img_id')->where('category_id','=',$category_id)->select();
        return $products;
    }

    public function detailImg()
    {
        return $this->hasMany('ProductImage','product_id','id')->field('id,img_id,order,product_id');
    }


    public function properties()
    {
        return $this->hasMany('ProductProperty','product_id','id')->field('id,name,detail,product_id');
    }

    public static function getProductDetail($id){
        $product = self::with(['detailImg','detailImg.img','properties'])->field('id,name,price,stock,category_id,main_img_url,from,img_id,summary')->find($id);
        return $product;
    }
}
