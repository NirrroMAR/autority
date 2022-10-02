<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'data' => [
                'layout' => 'back',
                'template' => 'index',
                'controllerName' => 'BackController',
                'pageTitle' => 'Back index',
                'debug_mode' => $this->getParameter('app.debug_mode')
            ]
        ]);
    }
}
