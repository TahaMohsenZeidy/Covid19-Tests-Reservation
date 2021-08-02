<?php

namespace App\Security;

use App\Entity\Patient;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PatientEnabledChecker implements UserCheckerInterface
{

    /**
     * Checks the user account before authentication.
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Patient) {
            return;
        }

        if (!$user->isEnabled()) {
            throw new DisabledException();
        }
    }

    /**
     * Checks the user account after authentication.
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user)
    {

    }
}