<?php
namespace app\admin\support;

use app\admin\model\Admin;
use Firebase\JWT\JWT as JwtToken;
use Firebase\JWT\Key;

class Jwt
{
    public static function create(Admin $admin)
    {
        $payload = [
            'iat' => time(),
            'exp' => time() + 86400,
            'nbf' => time(),
            'uid' => $admin->id,
            'email' => $admin->email
        ];

        return JwtToken::encode($payload, config('catch.jwt.key'), config('catch.jwt.algorithm'));
    }


    public static function verify($token)
    {
        $key = config('catch.jwt.key');

        $decode = JwtToken::decode($token, new Key($key, config('catch.jwt.algorithm')));

        return $decode->uid;
    }
}
