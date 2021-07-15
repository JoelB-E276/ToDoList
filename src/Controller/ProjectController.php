<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// Permet l'accès si authentifié
/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */

class ProjectController extends AbstractController
{
    // Affiche les projets de l'util connecté
    #[Route('/', name: 'projects', methods: ['GET','POST'])]
    public function index(ProjectRepository $projectRepository, Request $request): Response
    {

        $projects = $this->getUser()->getProjects();

        return $this->render('projects/index.html.twig', [
            'projects' => $projects,
        ]);
    }



    #[Route('/new', name: 'projects_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }


    //affiche les détails du projet et les tâche associées
    #[Route('/{id}', name: 'projects_show', methods: ['GET'])]
    public function show(Project $project, TaskRepository $TaskRepository, int $id): Response
    {
        dd($TaskRepository);
        $tasks = $TaskRepository->find($id);
    
        return $this->render('projects/show.html.twig', [
            'project' => $project,
            'tasks' => $tasks,

        ]);
    }






    #[Route('/{id}/edit', name: 'projects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projects_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
    }
}
