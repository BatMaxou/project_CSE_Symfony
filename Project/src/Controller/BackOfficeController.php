<?php

namespace App\Controller;

use App\Entity\Partnership;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\PartnershipRepository;
use App\Form\PartnershipType\PartnershipType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

    /*
    * ajax a faire
    */
    #[Route(path: '/admin/partenariat', name: 'backoffice_partnership')]
    public function partnership(PartnershipRepository $partnershipRepo, Request $request, EntityManagerInterface $manager): Response
    {
        $path = [['Infos', 'backoffice'], ['Partenariat', 'backoffice_partnership']];

        $partnerships = $partnershipRepo->findAll();

        // form a creer
        $partnership = new Partnership();
        $formPartner = $this->createForm(PartnershipType::class, $partnership);
        $formPartner->handleRequest($request);

        $id = $request->get('modify-id-partnership');
        if ($formPartner->isValid()) {
            $partner = $partnershipRepo->find($id);
            $partner->setNamePartnership($request->get('modify-name-partnership-' . $id));
            $partner->setDescriptionPartnership($request->get('modify-description-partnership-' . $id));
            $partner->setLinkPartnership($request->get('modify-link-partnership-' . $id));
            $partnershipRepo->save($partner, true);
        }

        return $this->render('backoffice/partnership/partnership.html.twig', [
            'path' => $path,
            'partnerships' => $partnerships,
            'formPartnership' => $formPartner->createView(),
        ]);
    }
}
