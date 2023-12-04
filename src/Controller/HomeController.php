<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/home", name:"home_")]
class HomeController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Homepage',
        ]);
    }
}
