<?php

namespace App\Controller;

use App\Entity\Partnership;
use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Form\PartnershipType\PartnershipType;
use App\Form\AdminFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    // Page d'affichage / modification d'un admin
    // #[Route(path: "/admin/adminGestion/add", name: "adminAdd")]
    #[Route('/admin/adminGestion', name: 'adminGestion')]
    public function adminGestion(Request $request, UserPasswordHasherInterface $adminPasswordHasher, EntityManagerInterface $entityManager, AdminRepository $adminRepository = null, int $id = null): Response
    {
        $path = [['Tableau de bord', 'backoffice'], ['Gestion des admins', 'adminGestion']];

        $admins = $adminRepository->findAll();

        $form = $this->createForm(AdminFormType::class, null, [
            'action' => '/post/backoffice/adminGestion',
            'method' => 'POST',
        ]);

        $forms = array();

        for ($i = 0; $i < count($admins); $i++) {
            $forms[] = $form->createView();
        }

        return $this->render('/backoffice/admin/index.html.twig', [
            'path' => $path,
            'forms' => $forms,
            'admins' => $admins,
        ]);
    }

    // Page de suppression d'un admin
    #[Route(path: "/admin/adminGestion/delete/{id}", name: "adminDelete")]
    public function adminDelete(Request $request, AdminRepository $adminRepository, EntityManagerInterface $manager, int $id): Response
    {
        $path = [['Tableau de bord', 'backoffice'], ['Gestion des admins', 'adminGestion']];

        $admin = $adminRepository->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                "Pas d'admin trouvé pour l'id : " . $id
            );
        }

        $manager->remove($admin);
        $manager->flush();

        return $this->redirectToRoute('adminGestion', [
            'path' => $path,
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
            $partner->setName($request->get('modify-name-partnership-' . $id));
            $partner->setDescription($request->get('modify-description-partnership-' . $id));
            $partner->setLink($request->get('modify-link-partnership-' . $id));
            $partnershipRepo->save($partner, true);
        }

        return $this->render('backoffice/partnership/partnership.html.twig', [
            'path' => $path,
            'partnerships' => $partnerships,
            'formPartnership' => $formPartner->createView(),
        ]);
    }
}