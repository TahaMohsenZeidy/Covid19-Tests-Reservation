<?php
namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Patient;
use App\Entity\Tester;
use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;


class PatientRegisterSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGenerator $tokenGenerator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['patientRegistered', EventPriorities::PRE_WRITE]
        ];
    }

    public function patientRegistered(ViewEvent $event){
        $patient = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$patient instanceof Patient || !in_array($method, [Request::METHOD_POST])){
            return;
        }
        // we need to hash the password
        $patient->setIdentifier(
            $this->passwordEncoder->encodePassword($patient, $patient->getIdentifier())
        );

        // create confirmation token
        $patient->setConfirmationToken(
            $this->tokenGenerator->getRandomSecureToken()
        );
    }
}