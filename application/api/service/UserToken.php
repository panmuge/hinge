<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 11:50
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取session_key及openid异常,微信内部错误');
        }else{
            if(array_key_exists('errcode',$wxResult)){
                $this->processLoginError($wxResult);
            }else{
                return $this->granToken($wxResult);
            }
        }
    }

    private function granToken($wxResult){
        //拿到openid和session_key
        //验证openid是否存在
        //如果不存在新增一条user表数据
        //生成令牌，准备缓存数据，写入缓存
        //返回令牌到客户端
        //令牌结构
        //key Token
        //value wxResult uid scope
        $openid = $wxResult['openid'];
        $session_key = $wxResult['session_key'];

        $user = UserModel::getOneUser($openid,'id,openid');
        if($user){
            $uid = $user['id'];
        }else{
            $uid = $this->newUser(['openid'=>$openid,'session_key'=>$session_key]);
        }
        $cachedValue = $this->prepareCacheValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('seting.token_expire_in');
        $result = cache($key,$value,$expire_in);
        if(!$result){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }

    private function prepareCacheValue($wxResult,$uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = 16;
        return $cacheValue;
    }

    private function newUser($data=[]){
        $user = UserModel::create([
            'openid'=>$data['openid'],
            'session_key'=>$data['session_key'],
        ]);
        return $user->id;
    }



    private function processLoginError($wxResult){
        throw new WeChatException(['msg'=>$wxResult['errmsg'],'errorCode'=>$wxResult['errcode']]);
    }



}