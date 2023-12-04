<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;

class ContactController extends AbstractController {

    #[Route('/demande', name: 'demande')]
    public function demandeContact(Request $request, GestionContact $gestionContact): Response {
        $contact = new Contact();
        $form = $this->createFormBuilder($contact)
                ->add('titre')
                ->add('nom')
                ->add('prenom')
                ->add('mail')
                ->add('tel')
                ->getForm();
        return $this->render('contact/contact.html.twig', [
                    'formContact' => $form->createView(),
                    'titre' => 'Formulaire de conttact',
        ]);
    }
}
