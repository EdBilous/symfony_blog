<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 18.06.18
 * Time: 20:06
 */

namespace AppBundle\Subscriber;


use AppBundle\Entity\Article;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UpdaterSubscriber implements EventSubscriber
{
    /**
     * var Logger
     */
    private $logger;

    /** @var TokenStorage $tokenStorage */
    private $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Constructor
     *
     * @param TokenStorage $tokenStorage
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TokenStorage $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'postPersist',
            'preUpdate',
            'postUpdate',

        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (
            method_exists($entity, 'setUpdatedAt')
        ) {
            $entity->setUpdatedAt(new \DateTime('now'));
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (
            method_exists($entity, 'setCreatedAt')
            &&
            method_exists($entity, 'setUpdatedAt')
        ) {
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setUpdatedAt(new \DateTime('now'));
        }

        if (
            method_exists($entity, 'setSlug')
        ) {
            $entity->setSlug($this->getUrl($entity->getTitle()));
        }

    }

    /**
     * @param $str
     * @return mixed|null|string|string[]
     */
    private function getUrl($str)
    {

        $articleUrl = mb_strtolower($str);
        $articleUrl = str_replace(' ', '-', $articleUrl);
        $articleUrl = $this->transliteration($articleUrl);
        $articleIsset = $this->em
            ->getRepository('AppBundle:Article')
            ->findOneBy(['slug' => $articleUrl]);

        if (!$articleIsset) {
            return $articleUrl;
        } else {
            $url = $articleIsset->url;
            $exUrl = explode('-', $url);
            if ($exUrl) {
                $temp = (int)end($exUrl);
                $newUrl = $exUrl[0] . '-' . ++$temp;
            } else {
                $temp = 0;
                $newUrl = $articleUrl . '-' . ++$temp;
            }
            return $this->getUrl($newUrl);
        }
    }

    /**
     * @param $str
     * @return string
     */
    private function transliteration($str)
    {
        $st = strtr($str,
            array(
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
                'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
                'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
                'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'ph', 'х' => 'h', 'ы' => 'y', 'э' => 'e', 'ь' => '',
                'ъ' => '', 'й' => 'y', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh',
                'щ' => 'sh', 'ю' => 'yu', 'я' => 'ya', ' ' => '_', '<' => '_',
                '>' => '_', '?' => '_', '"' => '_', '=' => '_', '/' => '_',
                '|' => '_'
            )
        );
        $st2 = strtr($st,
            array(
                'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd',
                'Е' => 'e', 'Ё' => 'e', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i',
                'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o',
                'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
                'Ф' => 'ph', 'Х' => 'h', 'Ы' => 'y', 'Э' => 'e', 'Ь' => '',
                'Ъ' => '', 'Й' => 'y', 'Ц' => 'c', 'Ч' => 'ch', 'Ш' => 'sh',
                'Щ' => 'sh', 'Ю' => 'yu', 'Я' => 'ya'
            )
        );
        $translit = $st2;
        return $translit;
    }
}