<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/back/user')]
class UserController extends AbstractController
{    
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $countUser = count($users);

        return $this->render('back/user/index.html.twig', [
            'users' => $users,
            'countUser' => $countUser,
            'data' => [
                'layout' => 'back',
                'template' => 'user/index',
                'controllerName' => 'UserController',
                'pageTitle' => 'User index',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $date = new DateTimeImmutable('now');

        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);

        $randNumber = rand(0, 9999999);
        $user->setAvatar('https://avatars.githubusercontent.com/u/'.$randNumber.'?v=4');

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
   
        if ($form->isSubmitted() && $form->isValid()) {
            // before persisting the user, we need to hash the password
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->add($user, true);
            $this->addFlash('success', 'User created successfully');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'user/new',
                'controllerName' => 'UserController',
                'pageTitle' => 'New user',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
            'data' => [
                'layout' => 'back',
                'template' => 'user/show',
                'controllerName' => 'UserController',
                'pageTitle' => 'Show user',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'data' => [
                'layout' => 'back',
                'template' => 'user/edit',
                'controllerName' => 'UserController',
                'pageTitle' => 'Edit user',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }
        $this->addFlash('success', 'User deleted successfully');
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
