<?php

namespace App\Controller;

use App\Form\TextType;

use App\Entity\Partnership;
use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Form\PartnershipType\PartnershipType;
use App\Form\AdminFormType;
use App\Repository\CkeditorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    }
}
