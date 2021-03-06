<?php
declare(strict_types=1);

namespace Piv\Guestbook\Helpers\File;

class FileJpg extends AFilePicture
{

    /**
     * @param string $filename
     * @return false|resource
     */
    protected function createImageFromFile(string $filename)
    {
        return imagecreatefromjpeg($filename);
    }

    /**
     * @param $newImage
     * @param string $filename
     */
    protected function createFileFromImage($newImage, string $filename): void
    {
        imagejpeg($newImage, $filename);
    }
}
