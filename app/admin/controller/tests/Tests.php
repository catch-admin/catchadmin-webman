<?php

namespace app\admin\controller\tests;

use app\admin\controller\CatchController;
use app\admin\model\tests\Tests as TestsModel;

class Tests extends CatchController
{
	public function initialize(): void
	{
		$this->model = new TestsModel();
	}
}
