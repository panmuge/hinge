<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Theme as ThemeModel;
use app\admin\model\ImageModel;
use app\admin\validate\IDMustBePositiveInt;
class Theme extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        if(request()->isAjax()){
            //获取所有参数
            $param = input('param.');

            $page = $param['pageNumber'];
            $size = $param['pageSize'];
            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $selectResult = ThemeModel::getThemeByPage($where,$page,$size);
            $rows = [];
            foreach($selectResult as $key=>$vo){
                $vo = $vo->toArray();
                $rows[$key] = $vo;
                $rows[$key]['topicimg'] = '<img src="' . $vo['topicimg']['url'] . '" width="40px" height="40px">';
                $rows[$key]['headimg'] = '<img src="' . $vo['headimg']['url'] . '" width="40px" height="40px">';
                $rows[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }
            $return['total'] = ThemeModel::getThemeCount($where);  // 总数据
            $return['rows'] = $rows;

            return json($return);
        }
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function themesave(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        //验证数据
        (new IDMustBePositiveInt())->goCheck();
        //获取数据，具体实现
        $id = input('param.id');
        $theme = ThemeModel::getOneTheme($id);
        $this->assign([
            'theme'=>$theme
        ]);
        //输出
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
    //上传图片
    public function uploadImg()
    {
        if(request()->isAjax()){
            $type = request()->param("input.");
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'theme/images');
            if($info){
                $src =  '/' . date('Ymd') . '/' . $info->getFilename();
                //上传成功保存到image表
                $image = new ImageModel();
                $imgid = $image->addImage($src);
                return json(msg(0, ['src' => '/theme/images' .$src,"imgid"=>$imgid,"type"=>$type], 'success'));
            }else{
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }
    /**
     *按钮
     * */
    public function makeButton($id){
        return [
            '编辑' => [
                'auth' => 'theme/edit',
                'href' => url('theme/edit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'theme/delete',
                'href' => "javascript:themeDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}
