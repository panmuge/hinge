<?php

namespace app\api\model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id','banner_id','img_id'];
    public function img(){
        //相对关联 一对一关联 hasone()
        return $this->belongsTo('image','img_id','id')->field("id,url,from");
    }
}
