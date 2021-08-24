<?php

namespace App\EventListener;

use App\Entity\Patient;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof Patient) {
            return;
        }

        $data['id'] = $user->getId();
        $event->setData($data);
    }
}