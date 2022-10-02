<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = '';
        if ($this->getUser()) {
            $this->addFlash('warning', 'You are already logged in! <a href="/logout">Logout</a>');
            $lastUsername = $authenticationUtils->getLastUsername();
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash('danger', $error->getMessage());
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'data' => [
                'layout' => 'auth',
                'template' => 'security/login',
                'controllerName' => 'SecurityController',
                'pageTitle' => 'Login',
                'debug_mode' => $this->getParameter('app.debug_mode'),
            ]
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
