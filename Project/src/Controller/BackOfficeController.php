<?php

namespace App\Controller;

use App\Form\TextType;

use App\Entity\Partnership;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Form\PartnershipType\PartnershipType;
use App\Repository\CkeditorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackOfficeController extends AbstractController
{
    #[Route(path: '/admin/texts', name: 'texts')]
    public function texts(CkeditorRepository $rep): Response
    {
        $path = [['Tableau de bord', 'texts'], ['Textes', 'texts']];

        $texts = [
            'homepage' => $rep->findByZone('HomePage', 'zone'),
            'email' => $rep->findByZone('AboutUs', 'email'),
            'actions' => $rep->findByZone('AboutUs', 'actions'),
            'rules' => $rep->findByZone('AboutUs', 'reglement'),
        ];

        $form = $this->createForm(TextType::class, null, [
            'action' => '/post/backoffice/texts',
            'method' => 'POST'
        ]);

        return $this->render('backoffice/texts/index.html.twig', [
            'path' => $path,
            'texts' => $texts,
            'form' => $form->createView(),
        ]);
    }
}
