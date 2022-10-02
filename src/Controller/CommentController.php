<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
    $comments=$commentRepository->findAll();
        return $this->render('back/comment/index.html.twig', [
            'comments' => $comments,
            'countComments' => count($comments),
            'data' => [
                'layout' => 'back',
                'template' => 'comment/index',
                'controllerName' => 'CommentController',
                'pageTitle' => 'Comment index',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentRepository $commentRepository): Response
    {
        $date = new DateTimeImmutable('now');
        $comment = new Comment();

        $comment->setCreatedAt($date);
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment, true);
            $this->addFlash('success', 'Comment created successfully');
            return $this->redirectToRoute('app_comment_edit', ['id' => $comment->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'comment/new',
                'controllerName' => 'CommentController',
                'pageTitle' => 'New comment',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('back/comment/show.html.twig', [
            'comment' => $comment,
            'data' => [
                'layout' => 'back',
                'template' => 'comment/show',
                'controllerName' => 'CommentController',
                'pageTitle' => 'Show comment',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment, true);
            $this->addFlash('success', 'Comment updated successfully');
            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'comment/edit',
                'controllerName' => 'CommentController',
                'pageTitle' => 'Edit comment',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
        }
        $this->addFlash('success', 'Comment deleted successfully');
        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
