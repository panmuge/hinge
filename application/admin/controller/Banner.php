<?php
namespace app\admin\controller;

use app\admin\model\BannerModel;
// use app\admin\model\BannerItemModel;
use app\admin\validate\BannerValidate;
use app\admin\validate\IDMustBePositiveInt;
class Banner extends Base
{
    //查询已经存在banner
    public function index()
    {
        if(request()->isAjax()){
            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;
            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $bannerModel = new BannerModel();

            $selectResult = $bannerModel->getBannerByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $bannerModel->getAllBanner($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
    
        // var_dump(session('action'));
        return $this->fetch();
    }

    public function bannerAdd()
    {
        //添加操作
        if(request()->isPost()){
            //数据验证
            (new BannerValidate())->goCheck();
            $param = input('post.');
       
            $banner = new BannerModel();
            $flag = $banner->addBanner($param);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        //输出
        return $this->fetch();
    }
    //添加banner
    public function save()
    {

    }
    //修改
    public function bannerEdit()
    {
        return true;
    }
    //删除
    public function bannerDel()
    {
        return true;
    }

    //banner-item操作
    public function bannerItem()
    {
        $id = input('param.id');
        (new IDMustBePositiveInt())->goCheck();
        if(request()->isAjax()){

            $id = input('param.id');

            $banner = new BannerModel();
            $banner = $banner->getBannerByID($id);

            $data = $banner->toArray();

            $selectResult = $data['banner_item'];
            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['thumbnail'] = '<img src="' . config('seting.img_prefix') .$vo['image']['url'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
                $selectResult[$key]['name'] = $data['name'];
            }
            // var_dump($selectResult);die;
            
            $return['name'] = $data['name'];
            $return['total'] = count($selectResult);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        $this->assign([
            "bannerid"=>$id,
        ]);
        return $this->fetch();
    }
    //添加
    public function bannerItemAdd()
    {
        //验证数据
        (new IDMustBePositiveInt())->goCheck();
        $id = input("param.id");
        if(request()->isAjax()){
            
        }
        var_dump($id);die;
        // return $this->fetch();
    }
    //修改
    public function bannerItemEdit()
    {

        return $this->fetch();
    }
    //删除
    public function bannerItmeDel()
    {

    }

     /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id)
    {
        return [
            '编辑' => [
                'auth' => 'banner/banneritem',
                'href' => url('banner/banneritem', ['id' => $id]),
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