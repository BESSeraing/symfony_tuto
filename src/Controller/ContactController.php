<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

     /**
      * @Route("/contact", name="contact")
      */
     public function contact(MailerInterface $mailer) {
         $email = new Email();
         $email
             ->from('demo@bes-webedeveloper-seraing.be')
             ->to('jonathan.cambier@gmail.com')
             //->cc('cc@example.com')
             //->bcc('bcc@example.com')
             //->replyTo('fabien@example.com')
             //->priority(Email::PRIORITY_HIGH)
             ->subject('Time for Symfony Mailer!')
             ->text('Sending emails is fun again!')
             ->html('<p>See Twig integration for better HTML integration!</p>');

         $mailer->send($email);
         return new Response("email sent");
     }

}