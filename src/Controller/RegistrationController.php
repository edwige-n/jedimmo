<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;

class RegistrationController extends AbstractController
{
    #[Route('/api/registration', name: 'api_registration', methods: ['POST'])]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $decoded = json_decode($request->getContent(), true);
        $email = $decoded['email'];
        $password = $decoded['password'];
        $emailExists = $userRepository->findBy(['email' => $email]);

        if ($emailExists) {
            return new JsonResponse(['message' => 'Email already exists.'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush(); 

        return new JsonResponse(['message' => "Registered Successfully!"], Response::HTTP_OK);
    }
}
