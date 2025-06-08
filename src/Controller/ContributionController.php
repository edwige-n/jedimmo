<?php

namespace App\Controller; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;  
use App\Repository\ContributionRepository; 
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Contribution;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ProjectUpdater; 

class ContributionController extends AbstractController {

    #[Route('/contribution', name: 'all_contributions', methods:['get'])]
    public function index(ContributionRepository $contributionRepository, SerializerInterface $serializer): JsonResponse
    {
     $contributions = $contributionRepository->findAll(); 
     $contributionsJson = $serializer->serialize($contributions, 'json', ['groups' => 'getContributions']); 
     return new JsonResponse($contributionsJson, 200, [], true); 
    }

    /** all contributions related to one project - only visible to the project owner  */
    #[Route('/contribution/project/{id}', name: 'project_contributions', methods:['get'])]
    public function showProjectContributions(ContributionRepository $contributionRepository, int $id, SerializerInterface $serializer): JsonResponse
    {
        $contributions = $contributionRepository->findContributionsByProject($id);
        if(!$contributions){
            return new JsonResponse('No contributions for project matching id ' . $id, 404);
        }
        $contributionsJson = $serializer->serialize($contributions, 'json', ['groups' => 'getContributions']); 
        return new JsonResponse($contributionsJson, 200, [], true); 
    }
    /** all contributions made by a user - only visible for the said user */
    #[Route('/contribution/user/{id}', name: 'user_contributions', methods:['get'])]
    public function showUserContributions(ContributionRepository $contributionRepository, int $id, SerializerInterface $serializer): JsonResponse
    {
        $contributions = $contributionRepository->findContributionsByUser($id);
        if(!$contributions){
            return new JsonResponse('No contributions for project matching id ' . $id, 404);
        }
        $contributionsJson = $serializer->serialize($contributions, 'json', ['groups' => 'getContributions']);
        return new JsonResponse($contributionsJson, 200, [], true); 
    }

    #[Route('/contribution/create', name: 'create_contribution', methods: ['post'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UserRepository $userRepository, ProjectRepository $projectRepository, ProjectUpdater $projectUpdater): JsonResponse
    {
        $contribution = $serializer->deserialize($request->getContent(), Contribution::class, 'json');
        $content = $request->toArray(); 
        $projectId = $content['project']; 
        $userId = $content['contributor'];
        $contribution->setContributor($userRepository->find($userId)); 
        $contribution->setProject($projectRepository->find($projectId));
        $entityManager->persist($contribution); 
        $projectUpdater->addAmount($projectRepository->find($projectId), $content['amount']); 
        $entityManager->flush(); 
        return new JsonResponse("Payment successful!", 201, [], true); 
    }

}