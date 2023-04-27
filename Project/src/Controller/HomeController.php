<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Subscriber;
use App\Form\ContactType;
use App\Form\SubscriberType;
use App\Form\ClientSurveyType;
use App\Service\Validator;
use App\Service\StaticPathList;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\ImageTicketingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function formNewsletter(StaticPathList $staticPathList): Response
    {
        $form = $this->createForm(SubscriberType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_abonnement_newsletter')),
            'method' => 'POST'
        ]);

        return $this->render('includes/form/_newsletter.html.twig', [
            'form' => $form,
        ]);
    }

    public function formSurvey(StaticPathList $staticPathList, SurveyRepository $surveyRepo, ResponseRepository $responseRepo): Response
    {
        try {
            // récupérer le sondage actif
            $surveyActive = $surveyRepo->findActiveSurvey();

            // récupérer les réponses associées au survey
            foreach (($responseRepo->findResponsesBySurveyId($surveyActive->getId())) as $response) {
                $responses[$response->getText()] = $response->getId();
            }

            $form = $this->createForm(ClientSurveyType::class, null, [
                'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_reponse_sondage')),
                'method' => 'POST',
                // array associatif text => id pour le ChoiceType
                'responses' => $responses
            ]);
        } catch (\Throwable $th) {
            return new Response('<p class="no-survey">Aucun sondage disponible pour le moment</p>');
        }

        return $this->render('includes/form/_survey.html.twig', [
            'form' => $form,
            'survey' => $surveyActive,
        ]);
    }

    public function formContact(staticPathList $staticPathList): Response
    {
        $formContact = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl($staticPathList->getRequestPathByName('envoi_contact')),
            'method' => 'POST'
        ]);

        $formContact->remove('id');

        return $this->render('includes/form/_contact.html.twig', [
            'formContact' => $formContact,
        ]);
    }

    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function home(staticPathList $staticPathList, PartnershipRepository $partnerRepo, TicketingRepository $ticketingRep, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil')];

        $ckeditor = $ckeditorRep->findByPage('HomePage');
        $ticketing = $ticketingRep->findByType('limitée');
        $nbOffer = count($ticketing);
        // counting the number of pages with 4 offers per page
        $nbPage = ($nbOffer % 4 === 0 || $nbOffer < 0) ? $nbOffer / 4 : intdiv($nbOffer, 4) + 1;
        // get 3 random image from database
        $imgPartner = $partnerRepo->imagePartner();

        return $this->render('home_page/index.html.twig', [
            'paths' => $paths,
            'ckeditor' => $ckeditor,
            'ticketing' => $ticketing,
            'nbOffer' => $nbOffer,
            'nbPage' => $nbPage,
            'image' => $imgPartner,
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership', methods: ['GET'])]
    public function partnership(staticPathList $staticPathList, PartnershipRepository $partnershipRepo): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Partenariats')];

        $partnership = $partnershipRepo->findAll();

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $nbOffer = count($partnership);
        // counting the number of pages with 4 offers per page
        $nbPage = ($nbOffer % 4 === 0 || $nbOffer < 0) ? $nbOffer / 4 : intdiv($nbOffer, 4) + 1;

        return $this->render('partnership/index.html.twig', [
            'paths' => $paths,
            'partnerships' => $partnership,
            'image' => $imgPartner,
            'nbPage' => $nbPage,
        ]);
    }

    #[Route(path: '/a_propos_de_nous', name: 'about_us', methods: ['GET'])]
    public function aboutUs(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, CkeditorRepository $ckeditorRep, MemberRepository $memberRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('A propos de nous')];

        $ckeditors = $ckeditorRep->findByPage('AboutUs');

        $actions = null;
        $email = null;
        $rules = null;

        foreach ($ckeditors as $ckeditor) {
            if ($ckeditor->getZone() === "actions") {
                $actions = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "email") {
                $email = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "rules") {
                $rules = $ckeditor->getContent();
            }
        }

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $members = $memberRep->findAll();

        return $this->render('about_us/index.html.twig', [
            'paths' => $paths,
            'image' => $imgPartner,
            'members' => $members,
            'actions' => $actions,
            'email' => $email,
            'rules' => $rules,
        ]);
    }

    #[Route(path: '/billeterie', name: 'ticketing', methods: ['GET'])]
    public function ticketing(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, SurveyRepository $surveyRepo, ResponseRepository $responseRepo, EntityManagerInterface $manager, TicketingRepository $ticketingRep, ImageTicketingRepository $imageTicketingRepository): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Billeterie')];

        $ticketingsPermanent = $ticketingRep->findByPermanent();
        $ticketingsLimited = $ticketingRep->findByLimited();
        $imageTicketing = $imageTicketingRepository->findAll();

        $partnership = $partnershipRepo->findAll();
        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        return $this->render('ticketing/index.html.twig', [
            'paths' => $paths,
            'ticketingsPermanent' => $ticketingsPermanent,
            'ticketingsLimited' => $ticketingsLimited,
            'imageTicketing' => $imageTicketing,
            'partnership' => $partnership,
            'image' => $imgPartner
        ]);
    }

    #[Route(path: '/billeterie/{slug}', name: 'offer', methods: ['GET'])]
    public function offer(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, TicketingRepository $ticketingRepo, string $slug): Response
    {
        $offer = $ticketingRepo->findBySlug($slug);

        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Billeterie'), array($offer->getName(), 'offer', $offer->getSlug())];

        // get info associated at the id in the url of the ticketing
        $imgPartner = $partnershipRepo->imagePartner();

        // si $offer retourne quelque chose et que l'id est un numérique alors on render sinon redirect
        if ($offer != NULL) {
            $imgOffer = $offer->getImageTicketings();

            return $this->render('ticketing/offer.html.twig', [
                'paths' => $paths,
                'image' => $imgPartner,
                'offer' => $offer,
                'imgOffer' => $imgOffer
            ]);
        }

        return $this->redirectToRoute('home');
    }

    #[Route(path: '/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(staticPathList $staticPathList, PartnershipRepository $partnershipRepo): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Contact')];
        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        return $this->render('contact/index.html.twig', [
            'paths' => $paths,
            'image' => $imgPartner,
        ]);
    }
}
