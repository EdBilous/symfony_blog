<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.06.18
 * Time: 23:00
 */

namespace BlogBundle\Services;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ImagesUploaderService
{
    /**
     * @var
     */
    private $targetDir;

    /**
     * ImagesUploaderService constructor.
     * @param $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}