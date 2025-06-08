<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\ProjectRepository;

class ProjectController extends AbstractController
{

    #[Route('/project', name: 'project', methods:['get'])]
    public function index(ProjectRepository $projectRepository, SerializerInterface $serializer): JsonResponse
    {
        $projects = $projectRepository->findAll();
        $projectsJson = $serializer->serialize($projects, 'json', ['groups' => 'getProjects']);
        return new JsonResponse($projectsJson, 200, [], true);
    }

    #[Route('/project/statut/{status}', name: 'project_by_status', methods: ['get'])]
    public function projectByStatus(ProjectRepository $projectRepository, string $status, SerializerInterface $serializer): JsonResponse
    {
        $projects = $projectRepository->findBy(['statut' => $status]);
        if(!$projects) {
            return new JsonResponse('No project with status' . $status, 404);
        }
       $projectsJson = $serializer->serialize($projects, 'json', ['groups' => 'getProjects']);
        return new JsonResponse($projectsJson, 200, [], true);
    }

    #[Route('/project/create', name: 'project_create', methods:['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $serializer->deserialize($request->getContent(), Project::class, 'json');
        $entityManager->persist($project);
        $entityManager->flush();

        $projectJson = $serializer->serialize($project, 'json', ['groups ' => 'getProjects']);
        return new JsonResponse($projectJson, 201, [], true);
    }

    #[Route('/project/{id}', name: 'project_display', methods:['get'])]
    public function show(int $id, SerializerInterface $serializer, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);
        if (!$project) {
            return new JsonResponse('No project matching id ' . $id, 404);
        }
        $projectJson = $serializer->serialize($project, 'json', ['groups' => 'getProjects']);

        return new JsonResponse($projectJson, 200, [], true);
    }

    #[Route('/project/update/{id}', name: 'project_update', methods:['put', 'patch'])]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id, SerializerInterface $serializer, UserRepository $userRepository, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);

        if(!$project) {
            return $this->json('No project matching id ' . $id, 404);
        }
        $serializer->deserialize($request->getContent(), Project::class, 'json', ['object_to_populate' => $project]);
        $entityManager->persist($project);
        $entityManager->flush();
        return $this->json($project, 201, [], ['groups' => 'getProjects']);
    }

    #[Route('/project/delete/{id}', name: 'project_delete', methods:['delete'])]
    public function delete(EntityManagerInterface $entityManager, int $id, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return new JsonResponse('No project found for id ' . $id, 404);
        }
        $entityManager->remove($project);
        $entityManager->flush();

        return new JsonResponse('Successfully deleted project with id ' . $id, 202);
    }

    #[Route('/user/projects/{id}', name: 'project_users', methods:['get'])]
    public function userProjects(ProjectRepository $projectRepository, SerializerInterface $serializer, int $id): JsonResponse
    {
        $projects = $projectRepository->findProjectsByUser($id);
        $projectsJson = $serializer->serialize($projects, 'json', ['groups' => 'getProjects']);
        return new JsonResponse($projectsJson, 200, [], true);
    }

}
