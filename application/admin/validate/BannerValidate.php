<?php
namespace app\admin\validate;

use think\Validate;

class BannerValidate extends BaseValidate
{
    protected $rule = [
        ['name', 'require', 'Banner名称不能为空'],
        ['description', 'require', 'Banner描述不能为空']
    ];

}