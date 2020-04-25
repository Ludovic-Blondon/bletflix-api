<?php

namespace App\Doctrine;

use App\Entity\Work;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use App\Entity\MediaObject;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Storage\StorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Filesystem\Filesystem;


class MediaObjectListener
{
    private $storage;
    private $entityManager;
    private $request;

    public function __construct(StorageInterface $storage, EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->storage = $storage;
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
    }

    /** @ORM\PrePersist */
    public function prePersistHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
        //exit('PrePersist');
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
//        $type = $this->request->request->get('type');
//
//        if (!empty(($type)))
//        {
//            $id = $this->request->request->get('id');
//
//            $work = new Work();
//            $work->setMediaObject($entity);
//
//            switch ($type) {
//                case 'movie':
//                    $work->setProduction($this->entityManager->getReference('Production', $id));
//                    break;
//                case 'serie':
//                    $work->setSeason($this->entityManager->getReference('Season', $id));
//                    break;
//
//                default:
//                    # code...
//                    break;
//            }
//        }
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(MediaObject $entity, PreUpdateEventArgs $event)
    {
        //exit('PreUpdate');
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
        //exit('PostUpdate');
    }

    /** @ORM\PostRemove */
    public function postRemoveHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
        //exit('PostRemove');
    }

    /** @ORM\PreRemove */
    public function preRemoveHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
        //exit('PreRemove');
        $filesystem = new Filesystem();

        if (file_exists('.'.$entity->originalMediaLocation()))
        {
            $filesystem->remove('.' . $entity->originalMediaLocation());
        }
    }

    /** @ORM\PreFlush */
    public function preFlushHandler(MediaObject $entity, PreFlushEventArgs $event)
    {
        //exit('PreFlush');
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(MediaObject $entity, LifecycleEventArgs $event)
    {
        //exit('PostLoad');
    }

}
