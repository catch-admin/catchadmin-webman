<?php
namespace app\admin\support\controller;

use app\admin\support\enums\Code;
use think\Paginator;

/**
 * 响应 Trait
 */
trait Response
{
    public function success($data = [], string $message = '操作成功', int $code = Code::SUCCESS)
    {
        if ($data instanceof Paginator) {
            return $this->paginate($data);
        }

        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error(string $message = '', int $code = Code::FAILED)
    {
        return json([
            'code' => $code,
            'message' => $message,
        ]);
    }

    public function paginate(Paginator $list)
    {
        return json([
            'code'    => Code::SUCCESS,
            'message' => '操作成功',
            'total'   => $list->total(),
            'limit'   => $list->listRows(),
            'data'    => $list->getCollection(),
        ]);
    }
}
