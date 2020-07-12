<?php

namespace App\Core\News\Services;

use Illuminate\Filesystem\FilesystemManager;

class ImageUploader
{
    /** @var FilesystemManager */
    private $filesystemManager;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;
    }

    public function upload(string $fileName, string $fileContents, string $disk = 'local')
    {
        $this->filesystemManager->disk($disk)->put($fileName, $fileContents);
    }
}
