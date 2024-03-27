<?php
namespace app\admin\exceptions;

use support\exception\BusinessException;
use Webman\Http\Request;
use support\Response;

abstract class CatchException extends BusinessException
{
    public function render(Request $request): ?Response
    {
        // json请求返回json数据
        if ($request->expectsJson()) {
            return json(['code' => $this->getCode() ?: 500, 'message' => $this->getMessage()]);
        }
        // 非json请求则返回一个页面
        return new Response(200, [], $this->getMessage());
    }
}
