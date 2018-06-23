<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.06.18
 * Time: 23:16
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Article;
use BlogBundle\Services\ImagesUploaderService;
use Symfony\Component\HttpFoundation\File\File;



class ImagesUploadListener
{
    private $uploader;

    public function __construct(ImagesUploaderService $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // загрузка работает только для сущностей Article
        if (!$entity instanceof Article) {
            return;
        }

        $file = $entity->getImage();

        // загружать только новые файлы
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Article) {
            return;
        }

        if ($fileName = $entity->getImage()) {
            $entity->setImage(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }
}