<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController
{
    #[Route('{projectId}/tasks{id}', name: 'tasks', methods: ['GET', 'POST'])]
    public function tasks(ProjectRepository $projectRepository,int $projectId): Response
    {
        $task = new task();
        $project = $projectRepository->find($projectId);
        $task->setProject($project);

        return $this->render('tasks/index.html.twig', [
            'task' => $task,
        ]);
    }
}
