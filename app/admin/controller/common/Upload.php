<?php
namespace app\admin\controller\common;

use app\admin\controller\CatchController;
use app\admin\support\Upload as UploadSupport;

class Upload extends CatchController
{
    public function file()
    {

    }

    public function image(UploadSupport $upload)
    {
        return $this->success(
            $upload->setUploadedFile($this->request->file('image'))->upload()
        );
    }
}
