<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/tag')]
class TagController extends AbstractController
{
    #[Route('/', name: 'app_tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {   $tags = $tagRepository->findAll();
        $countTags = count($tags);
        return $this->render('back/tag/index.html.twig', [
            'tags' => $tags,
            'countTags' => $countTags,
            'data' => [
                'layout' => 'back',
                'template' => 'tag/index',
                'controllerName' => 'TagController',
                'pageTitle' => 'Tag index',
            ]
        ]);
    }

    #[Route('/new', name: 'app_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TagRepository $tagRepository): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, true);

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'tag/new',
                'controllerName' => 'TagController',
                'pageTitle' => 'New tag',
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_tag_show', methods: ['GET'])]
    public function show(Tag $tag): Response
    {
        return $this->render('back/tag/show.html.twig', [
            'tag' => $tag,
            'data' => [
                'layout' => 'back',
                'template' => 'tag/show',
                'controllerName' => 'TagController',
                'pageTitle' => 'Show tag',
            ]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, true);

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'tag/edit',
                'controllerName' => 'TagController',
                'pageTitle' => 'Edit tag',
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_tag_delete', methods: ['POST'])]
    public function delete(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $tagRepository->remove($tag, true);
        }

        return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
