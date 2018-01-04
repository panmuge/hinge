<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url banner/:id
     * @http get
     * @id banner的id号
     * @throws BannerMissException
     */
    public function getBanner($id){
        //使用的参数都要进行验证
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if(empty($banner)){
            throw new BannerMissException();
        }
        return json($banner);
    }

}
