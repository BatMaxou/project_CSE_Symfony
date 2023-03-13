<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequestController extends AbstractController
{
    #[Route(path: '/post', name: 'post')]
    public function post(): Response
    {
        if (!empty($_POST['mail'])) {
            if (str_contains($_POST['mail'], '@')) {

                return new Response('Vous avez été abonné à la newsletter');
            }
            return new Response('Ce mail est déjà abonné');
        }

        return new Response('Veuillez renseigner un mail conforme');
    }
}
