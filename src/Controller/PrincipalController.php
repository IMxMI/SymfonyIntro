<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeZone;


class PrincipalController extends AbstractController {

    #[Route('/principal', name: 'app_principal')]
    public function index(): Response {
        return $this->render('principal/index.html.twig', [
                    'controller_name' => 'PrincipalController',
        ]);
    }

    #[Route('/welcome/{nom}', name: 'welcome')]
    public function welcome(string $nom) {
        return $this->render('principal/welcome.html.twig', array(
                    "nom" => $nom
        ));
    }
    
    #[Route('/message/{lieu}/{genre}')]
    public function messageGenreAge(int $lieu, string $genre){
        $date = new DateTime('now', new DateTimeZone("Europe/Paris"));
        $date = $date->format('l j F Y H:i');
        return $this->render('principal/messageGenreLieu.html.twig', array(
              "lieu" => $lieu,
              "genre" => $genre,
              "date" => $date
        ));
    }
}
