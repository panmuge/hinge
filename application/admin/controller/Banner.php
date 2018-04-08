<?php
namespace app\admin\controller;

use app\admin\model\BannerModel;
// use app\admin\model\BannerItemModel;
use app\admin\validate\BannerValidate;
use app\admin\validate\IDMustBePositiveInt;
use app\admin\model\ImageModel;
use think\Request;
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
        //验证传入数据
        (new IDMustBePositiveInt())->goCheck();
        //验证是否存在关联项目 item 不存在删除存在不删除 提示
        $id = input('param.id');
        $banner = new BannerModel();
        $result = $banner->delBanner($id);

        return json($result);
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
                $selectResult[$key]['operate'] = showOperate($this->makeItemButton($vo['id']));
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
    //编辑
    public function saveItem(){
        //验证数据
        
        return json([1,2,3,4,5,6,7,8]);
    }
    //添加
    public function itemAdd()
    {
        //验证数据
        (new IDMustBePositiveInt())->goCheck();
        $id = input("param.id");
        //获取参数
        if(request()->isAjax()){
            
        }
        $this->assign([
            "bannerid"=>$id
        ]);
        // var_dump($id);die;
        return $this->fetch();
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
    //上传横幅图片
    public function uploadImg()
    {
        if(request()->isAjax()){

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'images');
            if($info){
                $src =  '/images' . '/' . date('Ymd') . '/' . $info->getFilename();
                //上传成功保存到image表
                $image = new ImageModel();
                $imgid = $image->addImage($src);
                return json(msg(0, ['src' => $src,"imgid"=>$imgid], ''));
            }else{
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }
    /**
     *banner item 拼接操作按钮
     *@param $id
     *@return array
     */
    private function makeItemButton($id){
        return [
            '编辑'=>[
                'auth'=>'banner/banneritem',
                'href'=>'javascript:editBannerItem('.$id.')',
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除'=>[
                'auth' => 'banner/bannerdel',
                'href' => "javascript:bannerDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
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