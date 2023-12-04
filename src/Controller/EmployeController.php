<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/employe', name: 'employe_')]
class EmployeController extends AbstractController {

    #[Route('/voir/{id}', name: 'voir', requirements: ["id" => "\d+"], defaults: ["id" => 99])]
            function voir(int $id) {
        return $this->render('employe/voir.html.twig', compact('id'));
    }

    #[Route('/voirnomb/{nom}', name: 'voirnomb', requirements: ["nom" => "[B][a-zàéèêçîô]*"], defaults: ["id" => 99], options: ["utf8" => true])]
            function voirnomb(string $nom) {
        return $this->render('employe/voirnomb.html.twig', compact('nom'));
    }

    #[Route('/redirection/{nom}', name: 'redirection', requirements: ["nom" => "[A-Za-z]*"])]
    public function redirection(string $nom): RedirectResponse {
        return $this->redirectToRoute('employe_voirnomb', ['nom' => $nom]);
    }
}
