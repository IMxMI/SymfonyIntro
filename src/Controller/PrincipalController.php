<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employe;
use DateTime;
use DateTimeZone;
use App\Entity\Lieu;
use Symfony\Component\HttpFoundation\Request;

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
    public function messageGenreAge(int $lieu, string $genre) {
        $date = new DateTime('now', new DateTimeZone("Europe/Paris"));
        $date = $date->format('l j F Y H:i');
        return $this->render('principal/messageGenreLieu.html.twig', array(
                    "lieu" => $lieu,
                    "genre" => $genre,
                    "date" => $date
        ));
    }

    #[Route('/employes', name: 'employes')]
    public function afficheEmployes(ManagerRegistry $doctrine): Response {
        $employes = $doctrine->getRepository(Employe::class)->findAll();
        $titre = "Liste des employés";
        return $this->render('principal/employes.html.twig', compact('titre', 'employes'));
    }

    #[Route('/employe/{id}', name: 'employe')]
    public function afficheEmploye(int $id, ManagerRegistry $doctrine): Response {
        $employe = $doctrine->getRepository(Employe::class)->findOneById($id);
        $titre = "employé N°" . $id;
        return $this->render('principal/unemploye.html.twig', compact('titre', 'employe'));
    }

    #[Route("/employetout/{id}", name: "employetout", requirements: ["id" => "\d+"])]
    public function afficheUnEmployeTout(ManagerRegistry $doctrine, int $id): Response {
        $employe = $doctrine->getRepository(Employe::class)->find($id);
        $titre = "Employé";
        return $this->render('principal/unemployetout.html.twig', compact('titre', 'employe'));
    }

    #[Route("/lieutout/{id}", name: "lieutout", requirements: ["id" => "\d+"])]
    public function afficheUnLieuTout(ManagerRegistry $doctrine, int $id): Response {
        $lieu = $doctrine->getRepository(Lieu::class)->find($id);
        $titre = "Lieu" . $id;
        return $this->render('principal/unlieutout.html.twig', compact('titre', 'lieu'));
    }

    #[Route("/modif/salaire/{id}/{salaire}", name: "modifsalaire", requirements: ["id" => "\d+"])]
    public function modificationSalaireUnEmploye(ManagerRegistry $doctrine, int $id, float $salaire): Response {
        $entityManager = $doctrine->getManager();

        $employe = $entityManager->getRepository(Employe::class)->find($id);
        if (!$employe) {
            throw $this->createNotFoundException('Employé non trouvé pour cet ID : ' . $id);
        }

        $employe->setSalaire($salaire);

        $entityManager->flush();

        return $this->redirectToRoute('employe', ['id' => $id]);
    }

    #[Route("/employe/creer/{id}/", name: "creeremploye", requirements: ["id" => "\d+"])]
    public function creerUnEmploye(ManagerRegistry $doctrine, int $id): Response {
        $entityManager = $doctrine->getManager();
        $employe = new Employe();
        $lieu = $entityManager->getRepository(lieu::class)->find($id);

        $employe->setNom('Patrick');
        $employe->setSalaire(1543.3);
        $employe->setLieu($lieu);
        $entityManager->persist($employe);
        $entityManager->flush();

        return $this->redirectToRoute('lieutout', ['id' => $id]);
    }

    #[Route("/employe/suprimer/{id}/", name: "suprimeremploye", requirements: ["id" => "\d+"])]
    public function suprimerUnEmploye(ManagerRegistry $doctrine, int $id): Response {
        $entityManager = $doctrine->getManager();
        $employe = $entityManager->getRepository(Employe::class)->find($id);
        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('employes');
    }

    #[Route("/statslieu", name: "statslieu")]
    public function statsLieu(ManagerRegistry $doctrine): Response {
        $titre = "Statistiques";
        $lieus = $doctrine->getRepository(Lieu::class)->findAll();
        return $this->render('principal/statslieu.html.twig', compact('titre', 'lieus'));
    }

    #[Route("/{_locale}/cv", name: "cv", requirements: ["_locale" => "en|fr"])]
    public function cv(Request $request) {
        $langue = $request->getLocale();
        switch ($langue) {
            case "fr":
                $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/CVFR.pdf';
                return new Response(file_get_contents($pdfPath),200,['Content-Type' => 'application/pdf','Content-Disposition' => 'inline; filename="CVFR.pdf"',]);
                break;
            case "en":
                $pdfPath = $this->getParameter('kernel.project_dir') . '/public/pdf/CVEN.pdf';
                return new Response(file_get_contents($pdfPath),200,['Content-Type' => 'application/pdf','Content-Disposition' => 'inline; filename="CVEN.pdf"',]);
                break;
            default:
                break;
        }
    }
}
