<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface PatientedEntityInterface
{
    public function setPatient(UserInterface $patient): PatientedEntityInterface;
}