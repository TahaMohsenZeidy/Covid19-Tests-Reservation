<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\PatientConfirmation;
use App\Security\PatientConfirmationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PatientConfirmationSubscriber implements EventSubscriberInterface
{

    /**
     * @var PatientConfirmationService
     */
    private $confirmationService;

    public function __construct(PatientConfirmationService $confirmationService) {
        $this->confirmationService = $confirmationService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                'confirmPatient',
                EventPriorities::POST_VALIDATE,
            ],
        ];
    }

    public function confirmPatient(ViewEvent $event)
    {
        $request = $event->getRequest();

        if ('api_patient_confirmations_post_collection' !==
            $request->get('_route')) {
            return;
        }
        /** @var PatientConfirmation $confirmationToken */
        $confirmationToken = $event->getControllerResult();

        $this->confirmationService->confirmUser(
            $confirmationToken->confirmationToken
        );

        $event->setResponse(new JsonResponse(null, Response::HTTP_OK));
    }
}