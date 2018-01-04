<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 23:02
 */

namespace app\api\model;

class Banner extends BaseModel
{
    public function items(){
        return $this->hasMany("BannerItem","banner_id","id")->field("id,banner_id,img_id,key_word,type");
    }
    public static function getBannerByID($id)
    {
        //关联多个表 with(['items','items1'])
        $result = self::with(['items','items.img'])->field("id,name,description")->find($id);
        return $result;
    }
}