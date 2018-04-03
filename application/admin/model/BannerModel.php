<?php

namespace app\admin\model;

use think\Model;

class BannerModel extends BaseModel
{
    //表名称
    protected $table = "banner";
    //获取所有banner
    public  function getBannerAll()
    {
        $bannerall = $this->field('id,name,description')->select();
        return $bannerall;
    }
    //获取banner
    public function getBannerByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id Asc')->select();
    }

    /**
     * 根据搜索条件获取所有的banner数量
     * @param $where
     */
    public function getAllBanner($where)
    {
        return $this->where($where)->count();
    }

    //关联 banner_item
    public function bannerItem()
    {
        return $this->hasMany("BannerItemModel","banner_id","id");
    }
    //根据ID获取banner信息
    public function getBannerByID($id){
        return self::with(["bannerItem","bannerItem.image"])->find($id);
    }
    //验证是否存在banner-itme
    public  function getBannerItemByID($id){
        $bannerItems = self::with(['bannerItem'])->find($id)->toArray();
        return $bannerItems['banner_item'];
    }
    //删除banner
    public function delBanner($id){
        $bannerItem = $this->getBannerItemByID($id);
        if(empty($bannerItem)){
            try{
                $this->where('id', $id)->delete();
                return msg(1, '', '删除成功');
            }catch(PDOException $e){
                return msg(-1, '', $e->getMessage());
            }
        }else{
            return msg(-1, '','请先删除关联图片');
        }
    }
    /**
     *添加banner
     **/
    public function addBanner($data)
    {
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
}