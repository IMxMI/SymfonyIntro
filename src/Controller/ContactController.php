<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController {

    #[Route('/demande', name: 'demande')]
    public function demandeContact(Request $request): Response {
        $contact = new Contact();
        $form = $this->createFormBuilder($contact)
                ->add('titre', ChoiceType::class, array(
                    'choices' => array(
                        'Monsieur' => 'M',
                        'Madame' => 'F',
                    ), 'multiple' => false,
                    'expanded' => true,
                ))
                ->add('nom', TextType::class,
                        array(
                            'label' => 'Nom : ',
                            'required' => true,
                            'attr' => ['placeholder' => 'votre nom'],
                        ))
                ->add('mail', EmailType::class,
                        array(
                            'label' => 'Mail : ',
                            'required' => true,
                        ))
                ->add('tel', TelType::class,
                        array(
                            'label' => 'Téléphone : ',
                            'required' => true,
                        ))
                ->add('Envoyer', SubmitType::class)
                ->getForm();
        return $this->render('contact/contact.html.twig', [
                    'formContact' => $form->createView(),
                    'titre' => 'Formulaire de conttact',
        ]);
    }
}
