<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */

namespace app\api\controller\v2;

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
        return "This is v2 version";
    }


    public function getTest()
    {
        return "This is v2 version banner/test";
    }

}
