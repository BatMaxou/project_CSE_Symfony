<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackOfficeController extends AbstractController
{
    #[Route(path: '/admin', name: 'login')]
    public function login(): Response
    {
        return $this->render('base.html.twig');
    }
}
