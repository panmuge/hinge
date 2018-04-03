<?php

namespace app\admin\model;

use think\Model;

class ImageModel extends BaseModel
{
    //表名称
    protected $table = "image";

    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

    /**
     *保存图片地址到image
     *@param $src string 路径 
     **/
    public function addImage($src=''){
         try{
            $data = [
                "src"=>$src,
                "from"=>1
            ];
            $result = $this->save($data);
            if(false === $result){
                // 验证失败 输出错误信息
                return false;
            }else{

                return true;
            }
        }catch (\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

}