<?php

namespace app\admin\support;

use app\admin\exceptions\FailedException;
use support\Log;
use think\helper\Str;
use Webman\Http\UploadFile;

class Upload
{
    /**
     *
     * @var UploadFile
     */
    protected $file;

    protected $filesize;

    /**
     *
     * @var array
     */
    protected array $params;

    public function upload(): array
    {
        $this->filesize = $this->file->getSize();

        return $this->addUrl($this->getUploadPath());
    }

    /**
     * app url
     *
     * @param $path
     * @return mixed
     */
    protected function addUrl($path)
    {
        $path['path'] = config('app.app_host') . '/'.

            str_replace('\\', '/', $path['path']);

        return $path;
    }

    /**
     *
     * @return array
     * @throws FailedException
     */
    public function getUploadPath(): array
    {
        $this->checkSize();

        return $this->info($this->file->move($this->movePath()));
    }

    /**
     * @return string
     */
    protected function movePath(): string
    {
        return  base_path('public') . DIRECTORY_SEPARATOR . 'uploads'. DIRECTORY_SEPARATOR .
                date('Y_m_d') . DIRECTORY_SEPARATOR .
                md5(Str::random(10)) . '.'
                . $this->getUploadedFileExt();
    }

    /**
     * get uploaded file info
     *
     * @param $path
     * @return array
     */
    protected function info($path): array
    {
        return [
            'path'         => str_replace(base_path('public'), '', $path),
            'ext'          => $this->getUploadedFileExt(),
            'type'         => $this->getUploadedFileMimeType(),
            'size'         => $this->getUploadedFileSize(),
            'originalName' => $this->getOriginName(),
        ];
    }

    /**
     * check extension
     */
    protected function checkExt(): void
    {
        $extensions = config(sprintf('upload.%s.ext', $this->getUploadedFileMimeType()));

        $fileExt = $this->getUploadedFileExt();

        if (!in_array($fileExt, $extensions)) {
            throw new FailedException(sprintf('不支持该上传文件类型(%s)类型', $fileExt));
        }
    }

    /**
     * check file size
     */
    protected function checkSize(): void
    {
        $size = 10 * 1024 * 1024;

        if ($this->getUploadedFileSize() > $size) {
            throw new FailedException('超过文件最大支持的大小');
        }
    }

    /**
     * get uploaded file mime type
     *
     * @return string
     */
    protected function getUploadedFileMimeType(): string
    {
        if ($this->file instanceof UploadFile) {

            $imageMimeType = [
                'image/gif', 'image/jpeg', 'image/png', 'application/x-shockwave-flash',
                'image/psd', 'image/bmp', 'image/tiff', 'image/jp2',
                'application/x-shockwave-flash', 'image/iff', 'image/vnd.wap.wbmp', 'image/xbm',
                'image/vnd.microsoft.icon', 'image/x-icon', 'image/*', 'image/jpg',
            ];

            return in_array($this->file->getUploadMimeType(), $imageMimeType) ? 'image' : 'file';
        }

        return in_array($this->getUploadedFileExt(), config('upload.image.ext')) ? 'image' : 'file';
    }


    /**
     * get uploaded file extension
     *
     * @return array|string
     */
    protected function getUploadedFileExt()
    {
        if ($this->file instanceof UploadFile) {
            return strtolower($this->file->getUploadExtension());
        }

        // 直传文件
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    /**
     * get uploaded file size
     *
     * @return int
     */
    protected function getUploadedFileSize(): int
    {
        if ($this->file instanceof UploadFile) {
            return $this->filesize;
        }

        return 0;
    }

    /**
     * get origin name
     *
     * @return string|null
     */
    public function getOriginName(): ?string
    {
        // 上传图片获取
        if ($this->file instanceof UploadFile) {
            return $this->file->getUploadName();
        }

        return '';
    }



    /**
     * set uploaded file
     *
     * @param mixed $file
     * @return $this
     */
    public function setUploadedFile($file): Upload
    {
        $this->file = $file;

        return $this;
    }
}
