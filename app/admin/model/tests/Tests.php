<?php

namespace app\admin\model\tests;

use app\admin\model\CatchModel;

class Tests extends CatchModel
{
	/**
	 * 可写入的字段
	 * @var string[]
	 */
	protected $field = ['id', 'test', 'creator_id', 'created_at', 'updated_at', 'deleted_at'];
}
