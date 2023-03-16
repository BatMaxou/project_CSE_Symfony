<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackOfficeController extends AbstractController
{
    #[Route(path: '/admin', name: 'backoffice')]
    public function login(): Response
    {
        $path = [['Tableau de bord', 'backoffice']];

        return $this->render('backoffice/index.html.twig', [
            'path' => $path
        ]);
    }
}
