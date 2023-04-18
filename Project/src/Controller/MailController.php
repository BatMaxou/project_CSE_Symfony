<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    #[Route(path: '/test', name: 'mailTest', methods: ['GET'])]
    public function mailTest(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('mikimax1014@gmail.com')
            ->to('maximebatista.lycee@gmail.com')
            ->subject('Subject')
            ->html('Le text');

        $mailer->send($email);

        return $this->render('base.html.twig');
    }
}
