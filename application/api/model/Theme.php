<?php

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['head_img_id','topic_img_id'];
    public function topicImg(){
        return $this->belongsTo("image","topic_img_id","id")->field("id,url,from");
    }
    public function headImg(){
        return $this->belongsTo("image","head_img_id","id")->field("id,url,from");
    }
    public function products(){
        return $this->belongsToMany("Product","theme_product","product_id","theme_id")->field("id,name,price,stock,category_id,main_img_url,from,img_id");
    }

    public static function getThemeWithProducts($id){
        return self::with("products,topicImg,headImg")->field('id,name,description,head_img_id,topic_img_id')->find($id);
    }

}
