<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 12:19
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['create_time','delete_time','update_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}