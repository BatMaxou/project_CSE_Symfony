<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(): Response
    {
        $currentNav = ['Accueil'];

        return $this->render('homePage/index.html.twig', [
            'currentNav' => $currentNav,
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership')]
    public function partnership(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/a_propos', name: 'aboutUs')]
    public function about(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/billeterie', name: 'ticketing')]
    public function ticketing(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('base.html.twig');
    }
}
