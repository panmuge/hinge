<?php

namespace app\api\controller;

use app\admin\model\ImageModel;
use think\Request;
use think\Config;

/**
 * 公共接口
 */
class Common extends Base
{
    //上传横幅图片
    public function uploadImg()
    {
        if(request()->isAjax()){

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'images');
            if($info){
                $src =  '/' . date('Ymd') . '/' . $info->getFilename();
                //上传成功保存到image表
                $image = new ImageModel();
                $imgid = $image->addImage($src);
                return json(msg(0, ['src' => '/images' .$src,"imgid"=>$imgid], ''));
            }else{
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }
}