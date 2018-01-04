<?php

namespace app\api\controller\v1;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * 获取指定id的banner信息
     * @url theme/ids?=id1,id2,id3......
     * @http get
     * @ids theme的一组id号
     * @return 一组theme模型
     */
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
        $ids = explode(",",$ids);
        $result = ThemeModel::with("topicImg,headImg")->field("id,name,description,topic_img_id,head_img_id")->select($ids);
        if(empty($result)){
            throw new ThemeException();
        }
        return json($result);
    }

    public function getComplexOne($id){
        //验证
        (new IDMustBePositiveInt())->goCheck();
        //获取数据
        $theme = ThemeModel::getThemeWithProducts($id);
        if(empty($theme)){
            throw new ThemeException();
        }
        return json($theme);
    }

}
