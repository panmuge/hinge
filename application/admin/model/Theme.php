<?php

namespace app\admin\model;

use think\Model;

class Theme extends BaseModel
{
    //表名称
    protected $table="theme";

    public function topicimg(){
        return $this->hasOne("ImageModel","id","topic_img_id");
    }

    public function headimg(){
        return $this->hasOne("ImageModel","id","head_img_id");
    }
    //获取单条数据
    public static function getOneTheme($id){
        return self::with(["topicimg","headimg"])->find($id)->toArray();
    }

    public static function getThemeByPage($where,$page,$size){
        return self::with(["topicimg","headimg"])->where($where)->order('id desc')->paginate($size, true, ['page' => $page]);
    }

    public static function getThemeCount($where){
        return self::where($where)->count("id");
    }
}
