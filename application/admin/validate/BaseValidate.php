<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2018~2022 http://panmuge.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 盘木 <724864465@qq.com>
// +----------------------------------------------------------------------


namespace app\admin\validate;
use app\lib\exception\ParameterException;
use think\Exception;
use think\Validate;
use think\Request;
class BaseValidate extends Validate
{
    public function goCheck(){
        //获取参数
        $request = Request::instance();
        $params = $request->param();
        //对参数进行校验
        $result = $this->batch()->check($params);
        if($result){
            return true;
        }else{
            throw new ParameterException(["msg"=>$this->error]);
        }
    }
    
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }
    protected function isNotEmpty($value, $rule = '', $data = '', $field = ''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
}