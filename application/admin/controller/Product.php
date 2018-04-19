<?php
/**
 * 后台商品管理框控制器
 *@author 零秒
 *addtime 2018/04/10/16:10
 * */
namespace app\admin\controller;

use app\admin\validate\IDMustBePositiveInt;
use app\admin\model\ImageModel;
use app\admin\model\ProductModel;

use think\Request;

class Product extends Base
{
    //全部商品
    public function getAll(){
        if(request()->isAjax()){
            //验证提交数据
            
            //获取所有参数
            $param = input('param.');

            $page = $param['pageNumber'];
            $size = $param['pageSize'];
            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $selectResult = ProductModel::getProductByPage($where,$page,$size);
            $rows = [];
            foreach($selectResult as $key=>$vo){
                $vo = $vo->toArray();
                $rows[$key] = $vo;
                $rows[$key]['thumbnail'] = '<img src="' . $vo['main_img_url'] . '" width="40px" height="40px">';
                $rows[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = ProductModel::getPruductCount($where);  // 总数据
            $return['rows'] = $rows;

            return json($return);
        }
        return $this->fetch();
    }
    //已经上架商品
    public function sell(){

        return $this->fetch();
    }
    //仓库
    public function depot(){
        return $this->fetch();
    }
    //add
    public function productadd(){
        if(request()->isAjax()){

        }
        return $this->fetch();
    }
    //edit
    public function productEdit(){
        return $this->fetch();
    }
    //del
    public function delGoods(){

        return $this->fetch();
    }
    //上传图片
    public function uploadImg()
    {
        if(request()->isAjax()){

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'product/images');
            if($info){
                $src =  '/' . date('Ymd') . '/' . $info->getFilename();
                //上传成功保存到image表
                $image = new ImageModel();
                $imgid = $image->addImage($src);
                return json(msg(0, ['src' => '/product/images' .$src,"imgid"=>$imgid], ''));
            }else{
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }

    public function makeButton($id){
        return [
            '编辑' => [
                'auth' => 'banner/banneritem',
                'href' => url('product/productEdit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'banner/bannerdel',
                'href' => "javascript:bannerDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}