<?php
namespace app\admin\middleware;

use app\admin\support\log\Operate;
use Webman\MiddlewareInterface;

class JsonResponseMiddleware implements MiddlewareInterface
{
    public function process($request, callable $handler): \Webman\Http\Response
    {
        $response = $handler($request);
        $operate = new Operate();
        $operate->handle(\request(), $response);

        return $response;
    }
}
