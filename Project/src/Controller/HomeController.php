<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\SubscriberType;
use App\Form\ClientSurveyType;
use App\Service\StaticPathList;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\PartnershipRepository;
use App\Repository\ImageTicketingRepository;
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

    public function sidebarCkeditors(CkeditorRepository $rep): array
    {
        $ckeditors = $rep->findByPage('Client');

        $email = null;
        $phone = null;
        $place = null;

        foreach ($ckeditors as $ckeditor) {
            if ($ckeditor->getZone() === "email") {
                $email = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "phone") {
                $phone = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "place") {
                $place = $ckeditor->getContent();
            }
        }

        return array('email' => $email, 'phone' => $phone, 'place' => $place);
    }

    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function home(staticPathList $staticPathList, PartnershipRepository $partnerRepo, TicketingRepository $ticketingRep, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil')];

        $presentation = $ckeditorRep->findByPage('HomePage');
        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);
        $ticketing = $ticketingRep->findByLimitedActiveDesc();
        $nbOffer = count($ticketing);
        // counting the number of pages with 4 offers per page
        $nbPage = ($nbOffer % 4 === 0 || $nbOffer < 0) ? $nbOffer / 4 : intdiv($nbOffer, 4) + 1;
        // get 3 random image from database
        $imgPartner = $partnerRepo->imagePartner();

        return $this->render('home_page/index.html.twig', [
            'paths' => $paths,
            'presentation' => $presentation,
            'sideCkeditors' => $sideCkeditors,
            'ticketing' => $ticketing,
            'nbOffer' => $nbOffer,
            'nbPage' => $nbPage,
            'image' => $imgPartner,
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership', methods: ['GET'])]
    public function partnership(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Partenariats')];

        $partnership = $partnershipRepo->findAll();

        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $nbPartnership = count($partnership);
        // counting the number of pages with 4 offers per page
        $nbPage = ($nbPartnership % 4 === 0 || $nbPartnership < 0) ? $nbPartnership / 4 : intdiv($nbPartnership, 4) + 1;

        return $this->render('partnership/index.html.twig', [
            'paths' => $paths,
            'sideCkeditors' => $sideCkeditors,
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

        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $members = $memberRep->findAll();

        return $this->render('about_us/index.html.twig', [
            'paths' => $paths,
            'sideCkeditors' => $sideCkeditors,
            'image' => $imgPartner,
            'members' => $members,
            'actions' => $actions,
            'email' => $email,
            'rules' => $rules,
        ]);
    }

    #[Route(path: '/billetterie', name: 'ticketing', methods: ['GET'])]
    public function ticketing(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, TicketingRepository $ticketingRep, ImageTicketingRepository $imgTicketingRep, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Billetterie')];

        $ticketingsPermanent = $ticketingRep->findByPermanentDesc();
        $ticketingsLimited = $ticketingRep->findByLimitedActiveDesc();

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
        $partnershipRepo->findAll();

        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $nbLimitedOffers = count($ticketingsLimited);
        $nbPermanentOffers = count($ticketingsPermanent);

        // counting the number of pages with 4 offers per page
        $nbPagePermanent = ($nbPermanentOffers % 4 === 0 || $nbPermanentOffers < 0) ? $nbPermanentOffers / 4 : intdiv($nbPermanentOffers, 4) + 1;
        $nbPageLimited = ($nbLimitedOffers % 4 === 0 || $nbLimitedOffers < 0) ? $nbLimitedOffers / 4 : intdiv($nbLimitedOffers, 4) + 1;

        return $this->render('ticketing/index.html.twig', [
            'paths' => $paths,
            'ticketingsPermanent' => $ticketingsPermanent,
            'ticketingsLimited' => $ticketingsLimited,
            'sideCkeditors' => $sideCkeditors,
            'image' => $imgPartner,
            'nbPagePermanent' => $nbPagePermanent,
            'nbPageLimited' => $nbPageLimited,
        ]);
    }

    #[Route(path: '/billetterie/{slug}', name: 'offer', methods: ['GET'])]
    public function offer(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, TicketingRepository $ticketingRepo, CkeditorRepository $ckeditorRep, string $slug): Response
    {
        $offer = $ticketingRepo->findBySlug($slug);

        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Billetterie'), array(html_entity_decode($offer->getName()), 'offer', $offer->getSlug())];

        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);

        // get info associated at the id in the url of the ticketing
        $imgPartner = $partnershipRepo->imagePartner();

        // si $offer retourne quelque chose et que l'id est un numérique alors on render sinon redirect
        if ($offer != NULL) {
            $imgOffer = $offer->getImageTicketings();

            return $this->render('ticketing/offer.html.twig', [
                'paths' => $paths,
                'sideCkeditors' => $sideCkeditors,
                'image' => $imgPartner,
                'offer' => $offer,
                'imgOffer' => $imgOffer
            ]);
        }

        return $this->redirectToRoute('home');
    }

    #[Route(path: '/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Contact')];

        $sideCkeditors = $this->sidebarCkeditors($ckeditorRep);

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        return $this->render('contact/index.html.twig', [
            'paths' => $paths,
            'sideCkeditors' => $sideCkeditors,
            'image' => $imgPartner,
        ]);
    }
}
