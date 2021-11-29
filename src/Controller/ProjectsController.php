<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\task;
use App\Entity\User;
use App\Form\ProjectType;
use App\Form\NewProjectType;
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

#[Route('/projects')]
class ProjectsController extends AbstractController
{
    //test function getProjectByOrder
    
    #[Route('/', name: 'projects_index', methods: ['GET'])]
    public function getProjectByOrder(ProjectRepository $projectRepository): Response
    {
        $projects = $this->getUser()->getProjects();

        return $this->render('projects/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    
    
    
    
  /*   #[Route('/', name: 'projects_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $this->getUser()->getProjects();

        return $this->render('projects/index.html.twig', [
            'projects' => $projects,
        ]);
    }
 */

    // Création d'un projet
    #[Route('/new', name: 'projects_new', methods: ['GET', 'POST'])]
    public function newProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(NewProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $project->setUsers($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "Votre projet a été ajouté"
            );


            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }


    // Afficher projets et tâches associées 

    #[Route('/{id}', name: 'projects_show', methods: ['GET'])]
    public function show(Project $project, TaskRepository $TaskRepository, int $id): Response
    {
        $tasks = $project->getTask();
    
        return $this->render('projects/show.html.twig', [
            'project' => $project,
            'tasks' => $tasks,

        ]);
    }



    // Modifier un projet
    #[Route('/{id}/edit', name: 'projects_edit', methods: ['GET', 'POST'])]
    public function edit(ProjectRepository $projectRepository, Request $request, Project $project, int $id): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "Votre projet a bien été modifié"
            );


            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }


    //Supprimer un projet
    #[Route('/{id}', name: 'projects_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash(
                "success",
                "Projet définitivement supprimé"
            );
        }

        return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
    }
}
