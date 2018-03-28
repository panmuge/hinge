<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 12:19
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id','head_img_id','delete_time','update_time'];

    public function topicImg()
    {
        return $this->belongsTo('image','topic_img_id','id');
    }

    public function headImg()
    {
        return $this->belongsTo('image','head_img_id','id');
    }

    public function products()
    {
        return $this->belongsToMany('Product','theme_product',
            'product_id','theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}