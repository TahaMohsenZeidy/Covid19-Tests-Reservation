<?php
namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Patient;
use App\Entity\Tester;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;


class PasswordHashSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function hashPassword(ViewEvent $event){
        $patient = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$patient instanceof Patient || Request::METHOD_POST !== $method){
            if ($patient instanceof Tester){
                $patient->setIdentifier(
                    $this->passwordEncoder->encodePassword($patient, $patient->getIdentifier())
                );
            }
            else{
                return;
            }
        }
        // we need to hash the password
        $patient->setIdentifier(
            $this->passwordEncoder->encodePassword($patient, $patient->getIdentifier())
        );
    }
}