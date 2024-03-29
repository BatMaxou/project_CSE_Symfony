<?php

namespace App\Controller;

use App\Form\AdminType;
use App\Form\ContactType;
use App\Form\TextsType;
use App\Form\MemberType;
use App\Form\SurveyType;
use App\Form\TicketingType;
use App\Form\PartnershipType;
use App\Service\StaticPathList;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\TicketingRepository;
use App\Repository\ImageTicketingRepository;
use App\Repository\SurveyRepository;
use App\Repository\ContactRepository;
use App\Repository\CkeditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Repository\ResponseRepository;
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
            'actions' => $rep->findByZone('AboutUs', 'actions'),
            'rules' => $rep->findByZone('AboutUs', 'rules'),
            'email' => $rep->findByZone('Client', 'email'),
            'phone' => $rep->findByZone('Client', 'phone'),
            'place' => $rep->findByZone('Client', 'place'),
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

        $admins = $adminRepository->findAllByDesc();

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

    #[Route(path: 'sondages', name: 'backoffice_survey')]
    public function survey(StaticPathList $staticPathList, SurveyRepository $surveyRepo, ResponseRepository $respRepo): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Sondage')];

        $surveys = $surveyRepo->findAllByDescAndActive();
        $responses = $respRepo->findAll();

        $sortedResponse = array();

        // tableau associatif idSurvey => array(Response, Response ...)
        foreach ($responses as $response) {
            if (isset($sortedResponse[$response->getSurvey()->getId()])) {
                array_push($sortedResponse[$response->getSurvey()->getId()], $response);
            } else {
                $sortedResponse[$response->getSurvey()->getId()] = array($response);
            }
        }

        $addForm = $this->createForm(SurveyType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_sondage')),
            'method' => 'POST',
        ]);

        $editForm = $this->createForm(SurveyType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_sondage')),
            'method' => 'POST',
        ]);

        $formDelete = $this->createForm(SurveyType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supp_sondage')),
            'method' => 'POST',
        ]);

        $deleteForms = array();

        for ($i = 0; $i < count($surveys); $i++) {
            $deleteForms[] = $formDelete->createView();
        }

        return $this->render('backoffice/survey/index.html.twig', [
            'paths' => $paths,
            'addForm' => $addForm,
            'editForm' => $editForm,
            'deleteForms' => $deleteForms,
            'surveys' => $surveys,
            'responses' => $sortedResponse,
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
    public function dashboard(StaticPathList $staticPathList, SurveyRepository $surveyRepo, ResponseRepository $respRepo, CkeditorRepository $ckeditorRepo, ContactRepository $contactRepo): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord')];

        $ckeditor = $ckeditorRepo->findByPage('HomePage');
        $message = $contactRepo->getLastMessage();

        $activeSurvey = $surveyRepo->findActiveSurvey();
        if ($activeSurvey) {
            $responses = $respRepo->findResponsesBySurveyId($activeSurvey->getId());
        } else {
            $responses = [];
        }

        $stats = $surveyRepo->totalResponsesFor4LastSurveys();

        return $this->render('backoffice/index.html.twig', [
            'paths' => $paths,
            'survey' => $activeSurvey,
            'responses' => $responses,
            'ckeditor' => $ckeditor,
            'message' => $message,
            'stats' => $stats,
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

        return $this->render('backoffice/partnership/index.html.twig', [
            'paths' => $paths,
            'partnerships' => $partnerships,
            'formPartnership' => $forms,
            'deleteForm' => $deleteForms,
            'addFormPartner' => $addFormPartner
        ]);
    }

    #[Route(path: 'messages', name: 'backoffice_messages')]
    public function messages(StaticPathList $staticPathList, ContactRepository $contactRepo): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Messages')];

        // regupère tous les messages par ordre desc
        $messages = $contactRepo->findBy(array(), array('id' => 'DESC'));

        $deleteForm = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supprimer_msg')),
            'method' => 'POST',
        ]);

        // pour retirer les inputs qu'on ne va pas utiliser
        $deleteForm->remove('name');
        $deleteForm->remove('firstname');
        $deleteForm->remove('captcha');
        $deleteForm->remove('consent');

        $deleteForms = array();

        for ($i = 0; $i < count($messages); $i++) {
            $deleteForms[] = $deleteForm->createView();
        }

        return $this->render('backoffice/messages/index.html.twig', [
            'paths' => $paths,
            'messages' => $messages,
            'deleteForm' => $deleteForms,
        ]);
    }

    #[Route(path: 'messages/{id}', name: 'backoffice_message')]
    public function message(string $id, StaticPathList $staticPathList, ContactRepository $contactRepo): Response
    {
        $message = $contactRepo->find($id);

        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Messages'), array('Message de ' . $message->getEmail(), 'backoffice_message', $message->getId())];

        $repForm = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('rep_msg')),
            'method' => 'POST',
        ]);

        $repForm->remove('name');
        $repForm->remove('firstname');
        $repForm->remove('subject');
        $repForm->remove('captcha');
        $repForm->remove('consent');

        if ($message != NULL) {
            return $this->render('backoffice/messages/message.html.twig', [
                'paths' => $paths,
                'message' => $message,
                'repForm' => $repForm,
            ]);
        }

        return $this->redirectToRoute('home');
    }

    // Page d'affichage / modification d'un admin
    #[Route(path: 'billetterie', name: 'backoffice_ticketing')]
    public function ticketing(StaticPathList $staticPathList, TicketingRepository $ticketingRep, ImageTicketingRepository $imgTicketingRep, PartnershipRepository $partnershipRep): Response
    {
        $paths = [$staticPathList->getAdminPathByName('Tableau de bord'), $staticPathList->getAdminPathByName('Billetterie')];

        $ticketingsPermanent = $ticketingRep->findByPermanentDesc();
        $ticketingsLimited = $ticketingRep->findByLimitedDesc();

        // récupération des images
        foreach ($ticketingsPermanent as $offer) {
            foreach ($imgTicketingRep->findByOffer($offer) as $image) {
                $offer->addImageTicketing($image);
            };
        }
        foreach ($ticketingsLimited as $offer) {
            foreach ($imgTicketingRep->findByOffer($offer) as $image) {
                $offer->addImageTicketing($image);
            };
        }

        // récupération des partenaires
        $partnershipRep->findAll();

        $formAddTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_billetterie')),
            'method' => 'POST',
        ]);

        $formEditTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('modif_billetterie')),
            'method' => 'POST',
        ]);

        $formDeleteTicketing = $this->createForm(TicketingType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('supp_billetterie')),
            'method' => 'POST',
        ]);

        $formEditTicketings = array();
        $formDeleteTicketings = array();

        for ($i = 0; $i < (count($ticketingsLimited) + count($ticketingsPermanent)); $i++) {
            $formEditTicketings[] = $formEditTicketing->createView();
            $formDeleteTicketings[] = $formDeleteTicketing->createView();
        }

        return $this->render('/backoffice/ticketing/index.html.twig', [
            'paths' => $paths,
            'formAdd' => $formAddTicketing,
            'formEdits' => $formEditTicketings,
            'formDeletes' => $formDeleteTicketings,
            'ticketingsPermanent' => $ticketingsPermanent,
            'ticketingsLimited' => $ticketingsLimited
        ]);
    }
}
