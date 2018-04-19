<?php

namespace app\admin\model;

use think\Model;

class ProductModel extends BaseModel
{
    //表名称
    protected $table = "product";

    //count
    public static function getPruductCount($where){
        return self::where($where)->count('id');
    }
    
    public static function getProductByPage($where,$page=1, $size=20){
        $pagingData = self::where($where)->order('id desc')->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }
    //
    public function getPruductByWhere($where,$offset,$limit){
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
        
    }
    //关联产品图片表
    public function productImage()
    {
        return $this->hasMany("ProductImageModel","product_id","id");
    }
    //拼接主图完整url路径
    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
}