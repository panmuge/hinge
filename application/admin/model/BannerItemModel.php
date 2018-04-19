<?php

namespace app\admin\model;

use think\Model;

class BannerItemModel extends BaseModel
{
    //表名称
    protected $table = "banner_item";
    //获取器
    public function getTypeAttr($value){
        $status = [
            0=>"无导向",
            1=>"导向商品",
            2=>"导向专题",
        ];
        return $status[$value];
    }
    //获取器修改 字段信息
    // public function getKeyWordAttr($value,$data){
    //     $url = "";
    //     switch ($data['type']) {
    //         case '1':
    //             $url = config('setting.product').$value;
    //             break;
    //         case '2':
    //             $url = config('setting.theme').$value;;
    //             break;
    //         default:
    //             $url = "";
    //             break;
    //     }
    //     return $url;
    // }
    //修改器
    // public function setTypeAttr($value,$data){

    // }
    //关联image model
    public function image(){
        return $this->hasOne("ImageModel","id","img_id")->field("id,url,from");
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

    //添加数据
    public function addItem($param){
        $data = [
            "img_id"=>$param['img_id'],
            "key_word"=>$param['key_word'],
            "type"=>$param['type'],
            "banner_id"=>$param['banner_id']
        ];
        try{
            $result = $this->save($data);
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('banner/index'), '添加Banner成功');
            }
        }catch (\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }
    //修改
    public function put($id,$param){
        $data = [
            "img_id"=>$param['img_id'],
            "key_word"=>$param['key_word'],
            "type"=>$param['type'],
            "banner_id"=>$param['banner_id']
        ];
        try{
            $result = $this->save($data, ['id' => $id]);

            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('articles/index'), '编辑文章成功');
            }
        }catch(\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

}