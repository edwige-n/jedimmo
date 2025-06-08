<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Watchlist;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WatchlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class WatchlistController extends AbstractController
{
    #[Route('add_to_watchlist', name: 'add_to', methods: ['POST'])] 
    public function addToWatchlist(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ProjectRepository $projectRepository, UserRepository $userRepository, WatchlistRepository $watchlistRepository): JsonResponse
    {
        $watchlist = $serializer->deserialize($request->getContent(), Watchlist::class, 'json');
        $data = $request->toArray();
        $existing = $watchlistRepository->findOneBy([
            'user' => $data['user'],
            'project' => $data['project']
        ]);

        if ($existing) {
            return new JsonResponse("Already in the watchlist", 200); 
        }
        
        $watchlist->setProject($projectRepository->find($data['project']));
        $watchlist->setUser($userRepository->find($data['user']));
        $em->persist($watchlist);
        $em->flush();
        return new JsonResponse("Add to watchlist!", 201, [], true);
    }


    #[Route('/user/{id}/watchlist', name: 'watchlist', methods: ['GET'])]
    public function index(WatchlistRepository $watchlistRepository, SerializerInterface $serializer, int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        $items = $watchlistRepository->findBy(['user' => $user]);
        $itemsJson = $serializer->serialize($items, 'json', ['groups' => 'getWatchlist']);
        return new JsonResponse($itemsJson, 200, [], true);
    }
}
