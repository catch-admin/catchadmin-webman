<?php

declare(strict_types=1);

namespace app\admin\support;

use app\admin\exceptions\FailedException;
use app\admin\model\Admin;
use app\admin\exceptions\LoginFailedException;
use app\admin\support\enums\Code;
use app\admin\support\enums\Status;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use app\admin\support\log\Login as LoginLog;
use app\admin\support\Jwt;

class CatchAuth
{
    /**
     * @var mixed
     */
    protected mixed $auth;

    // 默认获取
    protected string $username = 'email';

    // 校验字段
    protected string $password = 'password';

    // 保存用户信息
    protected ?Admin $user = null;

    /**
     * @var bool
     */
    protected bool $checkPassword = true;

    /**
     * @param $condition
     * @return string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function attempt($condition): string
    {
        try {
            /* @var Admin $user */
            $admin = Admin::where($this->filter($condition))->find();

            if (!$admin) {
                throw new LoginFailedException();
            }
            if ($admin->status == Status::DISABLE) {
                throw new LoginFailedException('该用户已被禁用', Code::USER_FORBIDDEN);
            }

            if ($this->checkPassword && !password_verify($condition['password'], $admin->password)) {
                throw new LoginFailedException('登录失败, 请检查密码');
            }

            $token = $this->jwt($admin);
            $loginLog = new LoginLog();
            $loginLog->handle($admin, $token);
            return $token;
        } catch (\Exception $e) {
            $loginLog = new LoginLog();
            $loginLog->handle();
            throw new LoginFailedException($e->getMessage(), $e->getCode());
        }
    }


    /**
     * @param $token
     * @return mixed
     */
    public function user($token): mixed
    {
        $uid = Jwt::verify($token);

        $admin = Admin::where('id', $uid)->find();

        if (!$admin) {
            throw new FailedException('登录用户不合法', Code::LOST_LOGIN);
        }

        return $admin;
    }

    /**
     * @param array $condition
     * @return array
     */
    public function filter(array $condition): array
    {
        $where = [];

        $admin = new Admin();
        $fields = $admin->getField();

        foreach ($condition as $field => $value) {
            if (in_array($field, $fields) && $field != $this->password) {
                $where[$field] = $value;
            }
        }

        return $where;
    }


    /**
     * @return true
     */
    public function logout(): bool
    {
        // 加入黑名单
        JWTAuth::invalidate(JWTAuth::token()->get());

        return true;
    }

    /**
     * @param $user
     * @return string
     */
    protected function jwt($user): string
    {
        return Jwt::create($user);
    }

    /**
     * @return string
     */
    protected function jwtKey(): string
    {
        return 'admin_jwt_id';
    }


    /**
     * @param $field
     * @return $this
     */
    public function username($field): CatchAuth
    {
        $this->username = $field;

        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function password($field): CatchAuth
    {
        $this->password = $field;

        return $this;
    }

    /**
     * @return $this
     */
    public function ignorePasswordVerify(): CatchAuth
    {
        $this->checkPassword = false;

        return $this;
    }
}
