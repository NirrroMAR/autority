<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts=$postRepository->findAll();
        return $this->render('back/post/index.html.twig', [
            'posts' => $posts,
            'countPosts' => count($posts),
            'data' => [
                'layout' => 'back',
                'template' => 'post/index',
                'controllerName' => 'PostController',
                'pageTitle' => 'Post index',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $date = new \DateTimeImmutable('now');

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $post->setUpdatedAt($date);
        $post->setCreatedAt($date);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);
            $this->addFlash('success', 'Post created successfully');
            return $this->redirectToRoute('app_post_edit', ['id' => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'post/new',
                'controllerName' => 'PostController',
                'pageTitle' => 'New post',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('back/post/show.html.twig', [
            'post' => $post,
            'data' => [
                'layout' => 'back',
                'template' => 'post/show',
                'controllerName' => 'PostController',
                'pageTitle' => 'Show post',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);
            $this->addFlash('success', 'Post updated successfully');
            return $this->redirectToRoute('app_post_edit', ['id' => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'post/edit',
                'controllerName' => 'PostController',
                'pageTitle' => 'Edit post',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }
        $this->addFlash('success', 'Post deleted successfully');
        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
