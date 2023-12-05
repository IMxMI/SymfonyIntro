<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use App\Entity\Produit;

class GestionContact {

    private EntityManagerInterface $em;
    private MailerInterface $mailer;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer) {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public function creerContact(Contact $contact) {
        $contact->setDatePremierContact(new \DateTime());
        $this->em->persist($contact);
        $this->em->flush();
    }

    public function envoieMailContact(Contact $contact) {
        $email = (new TemplatedEmail())
                ->from(new Address('mxm.vernoux@gmail.com', 'Contact Symfony'))
                ->to($contact->getMail())
                ->subject('Demande de renseignement')
                ->text('Bonjour')
                ->attachFromPath('assets/pdf/presentation.pdf', 'Présentation')
                ->htmlTemplate('mails/mail.html.twig')
                ->context([
            'contact' => $contact
        ]);
        $this->mailer->send($email);
    }

    public function envoieTousPromotion() {
        $contacts = $this->em->getRepository(Contact::class)->findAll();
        $produits = $this->em->getRepository(Produit::class)->findAll();
        foreach ($contacts as $contact) {
            $email = (new TemplatedEmail())
                    ->from(new Address('mxm.vernoux@gmail.com', 'Contact Symfony'))
                    ->to($contact->getMail())
                    ->subject('Promotion voyage')
                    ->text('Bonjour')
                    ->attachFromPath('assets/pdf/presentation.pdf', 'Présentation')
                    ->htmlTemplate('mails/remise.html.twig')
                    ->context([
                'contact' => $contact,
                'produits' => $produits
            ]);
        }
        $this->mailer->send($email);
    }
}
