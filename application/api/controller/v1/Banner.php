<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 19:01
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;

class Banner{
	/**
	 * 获取指定id的banner信息
	 * @url /banner/:id
	 * @http GET
	 * @id  banner的id号
	 *
	 */
	public function getBanner($id)
	{
		(new IDMustBePostiveInt())->goCheck();
		$banner = BannerModel::getBannerById($id);
//        $banner->hidden(['update_time']);
		if (!$banner) {
            throw new BannerMissException();
        }
		return $banner;
	}
}