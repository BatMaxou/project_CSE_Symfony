<?php

namespace App\Controller;

use App\Service\StaticPathList;
use App\Form\TextsType;
use App\Form\MemberType;
use App\Form\AdminType;
use App\Form\PartnershipType;
use App\Form\TicketingType;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\TicketingRepository;
use App\Repository\ImageTicketingRepository;
use App\Repository\SurveyRepository;
use App\Repository\ContactRepository;
use App\Repository\CkeditorRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/admin/')]
class BackOfficeController extends AbstractController
{
    #[Route(path: 'textes', name: 'backoffice_text')]
    public function texts(StaticPathList $staticPathList, CkeditorRepository $rep): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Textes enrichis')];

        $texts = [
            'homepage' => $rep->findByZone('HomePage', 'zone'),
            'email' => $rep->findByZone('AboutUs', 'email'),
            'actions' => $rep->findByZone('AboutUs', 'actions'),
            'rules' => $rep->findByZone('AboutUs', 'rules'),
        ];

        $form = $this->createForm(TextsType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_textes')),
            'method' => 'POST'
        ]);

        return $this->render('backoffice/texts/index.html.twig', [
            'paths' => $paths,
            'texts' => $texts,
            'form' => $form->createView(),
        ]);
    }

    // Page d'affichage / modification d'un admin
    #[Route(path: 'comptes', name: 'backoffice_account')]
    public function adminGestion(StaticPathList $staticPathList, AdminRepository $adminRepository = null): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Comptes')];

        $admins = $adminRepository->findAll();

        $formAdd = $this->createForm(AdminType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_admin')),
            'method' => 'POST',
        ]);

        $formEdit = $this->createForm(AdminType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_admin')),
            'method' => 'POST',
        ]);

        $formDelete = $this->createForm(AdminType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supp_admin')),
            'method' => 'POST',
        ]);

        $formEdits = array();
        $formDeletes = array();

        for ($i = 0; $i < count($admins); $i++) {
            $formEdits[] = $formEdit->createView();
            $formDeletes[] = $formDelete->createView();
        }

        return $this->render('/backoffice/admin/index.html.twig', [
            'paths' => $paths,
            'formAdd' => $formAdd,
            'formEdits' => $formEdits,
            'formDeletes' => $formDeletes,
            'admins' => $admins,
        ]);
    }

    #[Route(path: 'backoffice_survey', name: 'backoffice_survey')]
    public function survey(StaticPathList $staticPathList, SurveyRepository $surveyRepo): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Sondage')];

        $questions = $surveyRepo->totalResponseBySurvey();
        $responses = $surveyRepo->totalResponseByQuestion();

        return $this->render('backoffice/survey/survey.html.twig', [
            'paths' => $paths,
            'questions' => $questions,
            'responses' => $responses,
            // encode responses en JSON pour l'utiliser en JS
            'responses_json' => json_encode($responses),
        ]);
    }

    #[Route(path: 'membres', name: 'backoffice_member')]
    public function member(StaticPathList $staticPathList, MemberRepository $rep): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Membres')];

        $members = $rep->findAllByDesc();

        $addForm = $this->createForm(MemberType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_membre')),
            'method' => 'POST',
        ])->createView();

        $editForm = $this->createForm(MemberType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_membre')),
            'method' => 'POST',
        ]);

        $deleteForm = $this->createForm(MemberType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('sup_membre')),
            'method' => 'POST',
        ]);

        $editForms = array();
        $deleteForms = array();

        for ($i = 0; $i < count($members); $i++) {
            $editForms[] = $editForm->createView();
            $deleteForms[] = $deleteForm->createView();
        }

        return $this->render('backoffice/member/index.html.twig', [
            'paths' => $paths,
            'members' => $members,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
            'addForm' => $addForm,
        ]);
    }

    #[Route(path: 'dashboard', name: 'backoffice_dashboard')]
    public function dashboard(StaticPathList $staticPathList, SurveyRepository $surveyRepo, CkeditorRepository $ckeditorRepo, ContactRepository $contactRepo): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord')];

        $ckeditor = $ckeditorRepo->findByPage('HomePage');
        $message = $contactRepo->getLastMessage();

        $questions = $surveyRepo->totalResponseBySurveyActive();
        $responses = $surveyRepo->totalResponseByQuestionActive();

        return $this->render('backoffice/index.html.twig', [
            'paths' => $paths,
            'questions' => $questions,
            'responses' => $responses,
            'ckeditor' => $ckeditor,
            'message' => $message,
            // encode responses en JSON pour l'utiliser en JS
            'responses_json' => json_encode($responses),
        ]);
    }

    #[Route(path: 'partenariats', name: 'backoffice_partnership')]
    public function partnership(StaticPathList $staticPathList, PartnershipRepository $partnershipRepo, Request $request, EntityManagerInterface $manager): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Partenariats')];

        $partnerships = $partnershipRepo->findAllByDesc();

        $addFormPartner = $this->createForm(PartnershipType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_partenariat')),
            'method' => 'POST',
        ])->createView();

        $form = $this->createForm(PartnershipType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_partenariat')),
            'method' => 'POST',
        ]);

        $deleteForm = $this->createForm(PartnershipType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supprimer_partenariat')),
            'method' => 'POST',
        ]);

        $forms = array();
        $deleteForms = array();

        for ($i = 0; $i < count($partnerships); $i++) {
            $forms[] = $form->createView();
            $deleteForms[] = $deleteForm->createView();
        }

        return $this->render('backoffice/partnership/partnership.html.twig', [
            'paths' => $paths,
            'partnerships' => $partnerships,
            'formPartnership' => $forms,
            'deleteForm' => $deleteForms,
            'addFormPartner' => $addFormPartner
        ]);
    }

    // Page d'affichage / modification d'un admin
    #[Route(path: 'billeterie', name: 'backoffice_ticketing')]
    public function ticketing(StaticPathList $staticPathList, TicketingRepository $ticketingRepository, ImageTicketingRepository $imageTicketingRepository, Request $request): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Billeterie')];

        $ticketings = $ticketingRepository->findAll();
        $ticketingPermanents = $ticketingRepository->findByPermanent();
        $ticketingLimiteds = $ticketingRepository->findByLimited();
        $imageTicketings = $imageTicketingRepository->findAll();

        $formAddTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_billeterie')),
            'method' => 'POST',
        ]);

        $formEditTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_billeterie')),
            'method' => 'POST',
        ]);

        $formDeleteTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supp_billeterie')),
            'method' => 'POST',
        ]);

        // $formEditImage = $this->createForm(ImageTicketingRepository::class, null, [
        //     'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_image_ticketing')),
        //     'method' => 'POST',
        // ]);

        // $formDeleteImage = $this->createForm(ImageTicketingRepository::class, null, [
        //     'action' => $this->generateUrl($staticPathList->getRequestPathByName('supp_image_ticketing')),
        //     'method' => 'POST',
        // ]);

        $formEditTicketings = array();
        $formDeleteTicketings = array();

        $formAddImages = array();
        // $formEditImages = array();
        // $formDeleteImages = array();-

        for ($i = 0; $i < count($ticketings); $i++) {
            $formEditTicketings[] = $formEditTicketing->createView();
            $formDeleteTicketings[] = $formDeleteTicketing->createView();
        }

        // for ($i = 0; $i < count($imageTicketings); $i++) {
        //     $formEditImages[] = $formEditImage->createView();
        //     $formDeleteImages[] = $formDeleteImage->createView();
        // }

        return $this->render('/backoffice/ticketing/index.html.twig', [
            'paths' => $paths,
            'formAddTicketing' => $formAddTicketing,
            'formEditTicketings' => $formEditTicketings,
            'formDeleteTicketings' => $formDeleteTicketings,
            // 'formEditImages' => $formEditImages,
            // 'formDeleteImages' => $formDeleteImages,
            'ticketings' => $ticketings,
            'ticketingPermanents' => $ticketingPermanents,
            'ticketingLimiteds' => $ticketingPermanents,
            'imageTicketings' => $imageTicketings,
        ]);
    }
}