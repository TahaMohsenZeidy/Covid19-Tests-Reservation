<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface PublishedDateEntityInterface
{
    public function setDate(\DateTimeInterface $dateTime): PublishedDateEntityInterface;
}