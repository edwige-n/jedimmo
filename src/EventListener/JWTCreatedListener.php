<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;

class JWTCreatedListener
{
    private LoggerInterface $logger;
    private UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        $this->logger = $logger;
        $this->userRepository = $userRepository;
    }
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $username = $event->getUser()->getUserIdentifier();
        $user = $this->userRepository->findOneBy(['email' => $username]);

        if(!$user) {
            $this->logger->error("User not found for this username : " . $username);
            return;
        }

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $event->setData($payload);
        $this->logger->info('payload jwt', $payload);
    }
}