<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
                      return new JsonResponse([
                           'message' => 'missing credentials',
                           ], Response::HTTP_UNAUTHORIZED);
        }
        $token = [];
        return new JsonResponse ([
                'user'  => $user->getUserIdentifier(),
                'token' => $token
        ], Response::HTTP_ACCEPTED);

    }
}
