<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19
 * Time: 23:22
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;


class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e)
    {

        if ($e instanceof BaseException) {
            //是用户操作产生的错误信息
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if (config("app_debug")) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = "服务器端错误";
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $request = Request::instance();
        $result = [
            "msg" => $this->msg,
            "error_code" => $this->errorCode,
            "request_url" => $request->url(),
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            "type" => "file",
            "path" => LOG_PATH,
            //单个日志文件的大小限制，超过后会自动记录到第二个文件
            "level" => ["error"],
            "file_size" => 5242880,
        ]);
        Log::record($e->getMessage(), "error");
    }
}