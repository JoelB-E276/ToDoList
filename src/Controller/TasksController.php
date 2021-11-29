<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Form\ProjectType;
use App\Form\NewTaskType;
use App\Form\NewProjectType;
use App\Repository\UsersRepository;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Permet l'accès si authentifié

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */

class TasksController extends AbstractController
{
    // Modifier un tâche
    #[Route('/tasks{id}', name: 'task_edit', methods: ['GET', 'POST'])]
    public function taskEdit(ProjectRepository $projectRepository, Request $request, Task $task, int $id): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "Votre tâche a bien été modifié"
            );


            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tasks/edit.html.twig', [
            "task" => $task,
            //  PQ creatView alors $form contient le formulaire
            "form" => $form->createView()
        ]);
    }


    //Créer un tâche 
    #[Route('/project{id}', name: 'task_new', methods: ['GET', 'POST'])]
    public function newTask(ProjectRepository $projectRepository, Request $request, int $id): Response
    {
        $task =new Task();
        $form = $this->createForm(NewTaskType::class, $task);
        $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) 
        {
            $project = $projectRepository->find($id);
            $task->setProject($project);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "Votre tâche a bien été créé"
            ); 


            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        } 

        return $this->render('tasks/new.html.twig', [
            "task" => $task,
            "form" => $form->createView()
        ]);
    }




}
