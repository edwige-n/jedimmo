<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    #[Route('/user/{id}', name: 'user_profile', methods: ['get'])]
    public function show(SerializerInterface $serializer, UserRepository $userRepository, int $id): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return new JsonResponse('No user matching this id ' . $id, 404);
        }
        $userJson = $serializer->serialize($user, 'json', ['groups' => 'getUsers']);
        return new JsonResponse($userJson, 200, [], true);
    }

    #[Route('/user/{id}/update', name: 'user_profile_update', methods: ['put', 'patch'])]
    public function update(EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $userRepository, Request $request, int $id): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return new JsonResponse('No user matching this id ' . $id, 404);
        }
        $serializer->deserialize($request->getContent(), User::class, 'json',  ['object_to_populate' => $user]);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse('Account updated !', 200);
    }

    #[Route('/user/{id}/delete', name: 'user_profile_delete', methods: ['delete'])]
    public function delete(EntityManagerInterface $entityManager, UserRepository $userRepository, int $id): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return new JsonResponse('No user matching this id ' . $id, 404);
        }
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse('Successfully deleted user with id ' . $id, 201);
    }


}
