<?php
namespace app\admin\controller;

use app\admin\support\generate\Generator;

class Generate extends CatchController
{
    public function index()
    {
        $params = $this->request->all();

        $generator = new Generator($params['controller'], $params['model'], $params['table'], $params);
        return $this->success($generator->generate());
    }
}
