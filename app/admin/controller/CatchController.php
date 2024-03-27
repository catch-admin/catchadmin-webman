<?php
namespace app\admin\controller;

use app\admin\support\controller\Auth;
use app\admin\support\controller\Resource;
use app\admin\support\controller\Response;
use Webman\Http\Request;

abstract class CatchController
{
    // 响应 trait
    // 资源路由操作 trait
    // 认证 trait
    use Response, Resource, Auth;

    /**
     * 子类自动注入 model
     *
     */
    protected $model;

    /**
     * 实际请求的 request 对象
     *
     * @var Request
     */
    protected Request $request;
    public function __construct()
    {
        $this->request = \request();

        $this->initialize();
    }

    public function initialize()
    {

    }
}
