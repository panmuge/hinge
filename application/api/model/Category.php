<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30
 * Time: 22:56
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ["topic_img_id"];
    public function img(){
        return $this->belongsTo("Image","topic_img_id","id")->field('id,url,from');
    }

    public static function getCategories(){
        return self::with(['img'])->field('id,name,topic_img_id')->select();
    }
}