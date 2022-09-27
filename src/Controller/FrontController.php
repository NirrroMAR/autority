<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(Request $r): Response
    {   
        $username = 'nicolas';
        if ($r->get('u')) {
            $username=$r->get('u');
        }
        return $this->render('front/index.html.twig', [
            'controller_name' => 'HomeController',
            'username' => $username
        ]);
    }
}
