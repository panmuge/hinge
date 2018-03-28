<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\RoleModel;
use app\admin\model\UserModel;
// use app\admin\model\UserType;
use think\Controller;
use think\captcha\Captcha;

class Login extends Controller
{
    // 登录页面
    public function index()
    {
        return $this->fetch('/login');
    }

    // 登录操作
    public function doLogin()
    {
        $userName = input("param.user_name");
        $password = input("param.password");
        $code = input("param.code");

        $result = $this->validate(compact('userName', 'password', "code"), 'AdminValidate');
        if(true !== $result){
            return json(msg(-1, '', $result));
        }

        $captcha = new Captcha();
        if (!$captcha->check($code)) {
            return json(msg(-2, '', '验证码错误'));
        }

        $userModel = new userModel();
        $hasUser = $userModel->findUserByName($userName);
        if(empty($hasUser)){
            return json(msg(-3, '', '管理员不存在'));
        }

        if(md5($password) != $hasUser['password']){
            return json(msg(-4, '', '密码错误'));
        }

        if(1 != $hasUser['status']){
            return json(msg(-5, '', '该账号被禁用'));
        }

        // 获取该管理员的角色信息
        $roleModel = new RoleModel();
        $info = $roleModel->getRoleInfo($hasUser['role_id']);

        session('username', $userName);
        session('id', $hasUser['id']);
        session('role', $info['role_name']);  // 角色名
        session('rule', $info['rule']);  // 角色节点
        session('action', $info['action']);  // 角色权限

        // 更新管理员状态
        $param = [
            'login_times' => $hasUser['login_times'] + 1,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time()
        ];
        $res = $userModel->updateStatus($param, $hasUser['id']);
        if(1 != $res['code']){
            return json(msg(-6, '', $res['msg']));
        }

        // ['code' => 1, 'data' => url('index/index'), 'msg' => '登录成功']
        return json(msg(1, url('index/index'), '登录成功'));
    }

    // 验证码
    public function checkVerify()
    {
        $captcha = new Captcha();
        $captcha->imageH = 32;
        $captcha->imageW = 100;
        $captcha->length = 4;
        $captcha->useNoise = true;
        $captcha->fontSize = 14;
        
        return $captcha->entry(); 
    }

    // 退出操作
    public function loginOut()
    {
        session('username', null);
        session('id', null);
        session('role', null);  // 角色名
        session('rule', null);  // 角色节点
        session('action', null);  // 角色权限

        $this->redirect(url('index'));
    }
}