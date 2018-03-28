<?php

namespace app\admin\model;

use think\Model;

class BannerItemModel extends Model
{
    //表名称
    protected $table = "banner_item";
    //关联image model
    public function image(){
        return $this->hasOne("ImageModel","img_id","id")->field("id,url,from");
    }
    //获取banner内容
    public function getBannerItemByWhere($where,$offset,$limit){
        $result =  self::with(['image'])->where($where)->limit($offset,$limit)->select();
        return $result;
    }
   
    //根据搜索条件获取所有的banneritem数量
    public function getCountBannerItem($where){
        return $this->table('banner_item')->where($where)->count();
    }

}