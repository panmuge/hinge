<?php
namespace app\install\controller;

use think\Controller;

class Index extends Controller
{

    public function index()
    {
        return $this->fetch();
    }
    //第一步 验证环境
    public function step1(){
        
    }
    //第二步 添加数据库信息
    public function step2(){

    }
    //第三步 添加数据信息
    public function step3(){
        
    }

    //第四步 安装成功
    public function complate(){

    }

}
