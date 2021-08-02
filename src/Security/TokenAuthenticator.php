<?php

namespace App\Security;

use App\Entity\Patient;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @param PreAuthenticationJWTUserToken $preAuthToken
     * @param UserProviderInterface $userProvider
     * @return null|\Symfony\Component\Security\Core\User\UserInterface|void
     */
    public function getUser($preAuthToken, UserProviderInterface $userProvider)
    {
        /** @var Patient $patient */
        $patient = parent::getUser(
            $preAuthToken,
            $userProvider
        );

        var_dump($preAuthToken->getPayload());

        if ($patient->getIdentifierChangeDate() &&
            $preAuthToken->getPayload()['iat'] < $patient->getIdentifierChangeDate()
        ) {
            throw new ExpiredTokenException();
        }

        return $patient;
    }

}