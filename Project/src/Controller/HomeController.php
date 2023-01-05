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
        return $this->render('base.html.twig');
    }
    
    #[Route(path: '/partenariat', name: 'partnership')]
    public function partnership(): Response
    {
        return $this->render('');
    }

    #[Route(path: '/a_propos', name: 'about')]
    public function about(): Response
    {
        return $this->render('');
    }

    // Offre et Billeterie ?

    #[Route(path: '/billeterie', name: 'ticketing')]
    public function ticketing(): Response
    {
        return $this->render('');
    }

    #[Route(path: '/offre', name: 'offer')]
    public function offer(): Response
    {
        return $this->render('');
    }

    #[Route(path: '/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('');
    }

    // accès backoffice depuis HomeController ?

    #[Route(path: '/back', name: 'back')]
    public function back(): Response
    {
        return $this->render('');
    }
}