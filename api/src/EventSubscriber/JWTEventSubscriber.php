<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJWTCreated',
            'lexik_jwt_authentication.on_jwt_invalidated' => 'onJWTInvalidated',
        ];
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();
        if ($user instanceof User && !$user->isIsValid()) {
            $event->markAsInvalid();
        }
    }

    public function onJWTInvalidated(JWTInvalidatedEvent $event)
    {
        $user = $event->getUser();
        if ($user instanceof User && !$user->isIsValid()) {
            $event->setCancelled(true);
        }
    }
}
