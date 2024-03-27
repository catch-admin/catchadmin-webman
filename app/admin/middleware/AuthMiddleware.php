<?php
namespace app\admin\middleware;

use app\admin\support\CatchAuth;

use app\admin\exceptions\FailedException;
use app\admin\support\enums\Code;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        try {
            $authorization = $request->header('Authorization');
            [$bearer, $token] = explode(' ', $authorization);
            if (!$token) {
                throw new FailedException('登录用户不合法', Code::LOST_LOGIN);
            }
            // 将用户信息设置到请求中，以便后续使用
            $auth = new CatchAuth();
            $user = $auth->user($token);
            if (!$user) {
                throw new FailedException('登录用户不合法', Code::LOST_LOGIN);
            }
            $request->admin = $user;
        } catch (\Exception $e) {
            if ($e instanceof ExpiredException) {
                throw new FailedException('token 过期', Code::LOGIN_EXPIRED);
            }
            if ($e instanceof SignatureInvalidException) {
                throw new FailedException('token 被加入黑名单', Code::LOGIN_BLACKLIST);
            }

            if ($e instanceof JWt) {
                throw new FailedException('token 不合法', Code::LOST_LOGIN);
            }

            throw new FailedException('登录用户不合法', Code::LOST_LOGIN);
        }

        return $handler($request);
    }
}
