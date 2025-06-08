<?php

namespace App\EventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogoutListener
{

    public function onLogout(LogoutEvent $event): void
    {
       $response = new JsonResponse([
           'success' => true,
           'message' => 'You have been logged out'
       ]);
        $event->setResponse($response);
    }
}