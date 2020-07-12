<?php

namespace App\Core\Interfaces;

interface DownloaderInterface
{
    /**
     * @param string $link
     *
     * @return array []News
     */
    public function download(string $link): array;
}
