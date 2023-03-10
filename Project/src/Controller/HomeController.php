<?php

namespace App\Controller;

use App\Repository\CkeditorRepository;
use App\Repository\TicketingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(TicketingRepository $ticketingRep, CkeditorRepository $ckeditorRep): Response
    {
        $path = [['Accueil', 'home']];
        $ckeditor = $ckeditorRep->findByPage('HomePage');
        $ticketing = $ticketingRep->findAll();

        return $this->render('homePage/index.html.twig', [
            'path' => $path,
            'ckeditor' => $ckeditor,
            'ticketing' => $ticketing,
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership')]
    public function partnership(): Response
    {
        $path = [['Accueil', 'home'], ['Partenariat', 'partnership']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/a_propos', name: 'aboutUs')]
    public function about(): Response
    {
        $path = [['Accueil', 'home'], ['A propos de nous', 'aboutUs']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/billeterie', name: 'ticketing')]
    public function ticketing(): Response
    {
        $path = [['Accueil', 'home'], ['Billeterie', 'ticketing']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/contact', name: 'contact')]
    public function contact(): Response
    {
        $path = [['Accueil', 'home'], ['Contact', 'contact']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }
}
