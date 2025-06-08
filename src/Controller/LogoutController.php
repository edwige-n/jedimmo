<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class LogoutController extends AbstractController {
    /**
     * @throws \Exception
     */
    #[Route('/api/logout', name: 'app_logout', methods: ['GET'])]
    public function logout() {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}