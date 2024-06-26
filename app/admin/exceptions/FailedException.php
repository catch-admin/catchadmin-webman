<?php
declare(strict_types=1);

namespace app\admin\exceptions;

use app\admin\support\enums\Code;

class FailedException extends CatchException
{
    protected $code = Code::FAILED;
}
