<?php

namespace App\Controller;

use App\Form\TextType;
use App\Form\MemberType;
use App\Form\AdminFormType;
use App\Entity\Partnership;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use App\Form\PartnershipType\PartnershipType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BackOfficeController extends AbstractController
{
    #[Route(path: '/admin/textes', name: 'texts')]
    public function texts(CkeditorRepository $rep): Response
    {
        $path = [['Tableau de bord', 'texts'], ['Textes', 'texts']];

        $texts = [
            'homepage' => $rep->findByZone('HomePage', 'zone'),
            'email' => $rep->findByZone('AboutUs', 'email'),
            'actions' => $rep->findByZone('AboutUs', 'actions'),
            'rules' => $rep->findByZone('AboutUs', 'rules'),
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

    // Page d'affichage / modification d'un admin
    // #[Route(path: "/admin/adminGestion/add", name: "adminAdd")]
    #[Route(path: '/admin/adminGestion', name: 'adminGestion')]
    public function adminGestion(AdminRepository $adminRepository = null): Response
    {
        $path = [['Tableau de bord', 'texts'], ['Gestion des admins', 'adminGestion']];

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
    public function adminDelete(AdminRepository $adminRepository, int $id): Response
    {
        $path = [['Tableau de bord', 'texts'], ['Gestion des admins', 'adminGestion']];

        $admin = $adminRepository->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                "Pas d'admin trouvé pour l'id : " . $id
            );
        }

        $adminRepository->remove($admin, true);

        return $this->redirectToRoute('adminGestion', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/admin/sondage', name: 'backoffice_sondage')]
    public function survey(SurveyRepository $surveyRepo): Response
    {
        $path = [['Infos', 'texts'], ['Sondage', 'backoffice_sondage']];

        $questions = $surveyRepo->totalResponseBySurvey();
        $responses = $surveyRepo->totalResponseByQuestion();

        return $this->render('backoffice/survey/survey.html.twig', [
            'path' => $path,
            'questions' => $questions,
            'responses' => $responses,
            // encode responses en JSON pour l'utiliser en JS
            'responses_json' => json_encode($responses),
        ]);
    }

    #[Route(path: '/admin/membres', name: 'backoffice_member')]
    public function member(MemberRepository $rep): Response
    {
        $path = [['Tableau de bord', 'texts'], ['Membre', 'backoffice_member']];

        $members = $rep->findAll();

        $form = $this->createForm(MemberType::class, null, [
            'action' => '/post/backoffice/member',
            'method' => 'POST',
        ]);

        $forms = array();

        for ($i = 0; $i < count($members); $i++) {
            $forms[] = $form->createView();
        }

        return $this->render('backoffice/member/index.html.twig', [
            'path' => $path,
            'members' => $members,
            'forms' => $forms,
        ]);
    }
}
