<?php


namespace App\EventListener;


use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use App\Interface\IHaveAuthor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class EntitySubscriber implements EventSubscriber
{

    /**
     * EntitySubscriber constructor.
     */
    public function __construct(protected TokenStorageInterface $tokenStorage)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }

    public function prePersist(LifecycleEventArgs $args) : void
    {
        $entity = $args->getObject();
        if(!($entity instanceof IHaveAuthor)) return;

        if($this->tokenStorage->getToken()){
            $user = $this->tokenStorage->getToken()->getUser();

            if($user instanceof User){
                $entity->setAuthor($user);
            }
        }
    }
}