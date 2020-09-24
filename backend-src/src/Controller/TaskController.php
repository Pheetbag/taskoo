<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/tasks")
 */
class TaskController extends AbstractController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/", name="task_list", methods={"GET"})
     */
    public function list()
    {
        $tasks = $this->taskRepository->findAllOrdered();

        return $this->json($tasks);
    }

    /**
     * @Route("/{id}/", name="task_one", methods={"GET"})
     */
    public function listOne(Task $task)
    {
        return $this->json($task);
    }

    /**
     * @Route("/", name="task_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        return $this->handleTaskForm(new Task(), $request);
    }


    /**
     * @Route("/{id}/", name="task_edit", methods={"PATCH"})
     */
    public function edit(Task $task, Request $request)
    {
        return $this->handleTaskForm($task, $request);
    }

    private function handleTaskForm(Task $task, Request $request): JsonResponse
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isSubmitted() OR !$form->isValid()) {
            return $this->json([
                'error' => 'There was a problem creating your task'
            ]);
        }

        $task = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();

        return $this->json($task);
    }

    /**
     * @Route("/{id}/", name="task_delete", methods={"DELETE"})
     */
    public function delete(Task $task)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'There was a problem deleting your task',
                'exception' => $exception->getMessage()
            ]);
        }

        return $this->json(['success' => 'Task deleted']);
    }
}
