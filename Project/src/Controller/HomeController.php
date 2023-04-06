<?php

namespace App\Controller;

use Exception;
use App\Entity\Survey;
use App\Entity\Contact;
use App\Form\SurveyType;
use App\Form\ContactType;
use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Form\SubscriberType;
use App\Entity\ImageTicketing;
use App\Form\UserResponseType;
use App\Service\StaticPathList;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Entity\Response as ResponseSurvey;
use App\Repository\ImageTicketingRepository;
use Symfony\Component\HttpFoundation\Request;
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
            $surveyActive = $surveyRepo->findQuestionActive();

            // récupérer les réponses associées au survey
            foreach (($responseRepo->findResponseBySurveyId($surveyActive->getId())) as $response) {
                $responses[$response->getText()] = $response->getId();
            }

            $form = $this->createForm(SurveyType::class, null, [
                'action' => $this->generateUrl($staticPathList->getRequestPathByName('ajout_reponse_sondage')),
                'method' => 'POST',
                // array associatif text => id pour le ChoiceType
                'responses' => $responses
            ]);
        } catch (\Throwable $th) {
            return new Response("Aucun sondage disponible pour le moment");
        }

        return $this->render('includes/form/_survey.html.twig', [
            'form' => $form,
            'survey' => $surveyActive,
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

        return $this->render('homePage/index.html.twig', [
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

        return $this->render('partnership/index.html.twig', [
            'paths' => $paths,
            'partnerships' => $partnership,
            'image' => $imgPartner
        ]);
    }

    #[Route(path: '/a_propos_de_nous', name: 'about_us', methods: ['GET'])]
    public function aboutUs(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, CkeditorRepository $ckeditorRep, MemberRepository $memberRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('A propos de nous')];

        $ckeditors = $ckeditorRep->findByPage('AboutUs');

        foreach ($ckeditors as $ckeditor) {
            if ($ckeditor->getZone() == "actions") {
                $actions = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() == "email") {
                $email = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() == "rules") {
                $rules = $ckeditor->getContent();
            }
        }

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $members = $memberRep->findAll();

        return $this->render('aboutUs/index.html.twig', [
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
        if ($offer != NULL and is_string($slug)) {
            $imgOffer = $offer->getImageTicketings();

            return $this->render('ticketing/offer.html.twig', [
                'paths' => $paths,
                'image' => $imgPartner,
                'offer' => $offer,
                'imgOffer' => $imgOffer
            ]);
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /*
     *ajax a faire
     */
    #[Route(path: '/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(staticPathList $staticPathList, PartnershipRepository $partnershipRepo, Request $request, EntityManagerInterface $manager, SubscriberRepository $subscriberRepo): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getClientPathByName('Contact')];

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            try {
                if (!empty($_POST['consent']) && $_POST['consent'] === 'on') {
                    if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $formContact->getData()->getEmailContact())) {
                        if ($subscriberRepo->countByMail($formContact->getData()->getEmailContact()) === 0) {
                            $sub = new Subscriber();
                            $sub->setEmail($formContact->getData()->getEmailContact());
                            $sub->setConsent(1);
                            $subscriberRepo->save($sub, true);
                        }
                    }
                }

                $contact = $formContact->getData();

                $manager->persist($contact);
                $manager->flush();

                $this->addFlash('success', 'Votre message a bien été envoyé !');

                return $this->redirectToRoute('contact');
            } catch (\Throwable $th) {
                $this->addFlash('error', 'Une erreur imprévu est survenu, veillez recharger la puis réessayer.');
            }
        }

        return $this->render('contact/index.html.twig', [
            'paths' => $paths,
            'image' => $imgPartner,
            'formContact' => $formContact->createView(),
        ]);
    }
}
