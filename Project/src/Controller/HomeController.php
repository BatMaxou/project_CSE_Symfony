<?php

namespace App\Controller;

use Exception;
use App\Entity\Survey;
use App\Entity\Contact;
use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Repository\SurveyRepository;
use App\Form\ContactType;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartnershipRepository;
use App\Entity\Response as ResponseSurvey;
use App\Repository\ImageTicketingRepository;
use App\Form\SubscriberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UserResponseType;
use App\Repository\MemberRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function formNewsletter(): Response
    {
        $form = $this->createForm(SubscriberType::class, null, [
            'action' => '/post/newsletter',
            'method' => 'POST'
        ]);

        return $this->render('includes/form/_newsletter.html.twig', [
            'form' => $form,
        ]);
    }

    public function formSurvey(SurveyRepository $surveyRepo, ResponseRepository $responseRepo): Response
    {
        // get the question active of the survey
        $questionActive = $surveyRepo->findQuestionActive();

        // get response associated at the question of the survey
        $responseQuestion = $responseRepo->findResponseById($questionActive->getId());

        $form = $this->createForm(UserResponseType::class, null, [
            'action' => '/post/survey',
            'method' => 'POST'
        ]);

        return $this->render('includes/form/_survey.html.twig', [
            'form' => $form,
            'question' => $questionActive,
            'response' => $responseQuestion,
        ]);
    }

    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function home(PartnershipRepository $partnerRepo, TicketingRepository $ticketingRep, CkeditorRepository $ckeditorRep): Response
    {
        /*
         * knp menu bundle
         */
        $path = [['Accueil', 'home']];
        $ckeditor = $ckeditorRep->findByPage('HomePage');
        $ticketing = $ticketingRep->findByType('permanente');
        $nbOffer = count($ticketing);
        // counting the number of pages with 3 offers per page
        $nbPage = ($nbOffer % 3 === 0 || $nbOffer < 0) ? $nbOffer / 3 : intdiv($nbOffer, 3) + 1;
        // get 3 random image from database
        $imgPartner = $partnerRepo->imagePartner();

        return $this->render('homePage/index.html.twig', [
            'path' => $path,
            'ckeditor' => $ckeditor,
            'ticketing' => $ticketing,
            'nbOffer' => $nbOffer,
            'nbPage' => $nbPage,
            'image' => $imgPartner,
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership', methods: ['GET'])]
    public function partnership(PartnershipRepository $partnershipRepo): Response
    {
        $path = [['Accueil', 'home'], ['Partenariat', 'partnership']];
        $partnership = $partnershipRepo->findAll();

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        return $this->render('partnership/index.html.twig', [
            'path' => $path,
            'partnerships' => $partnership,
            'image' => $imgPartner
        ]);
    }

    #[Route(path: '/a_propos_de_nous', name: 'aboutUs', methods: ['GET'])]
    public function about(PartnershipRepository $partnershipRepo, CkeditorRepository $ckeditorRep, MemberRepository $memberRep): Response
    {
        $path = [['Accueil', 'home'], ['A propos de nous', 'aboutUs']];
        $ckeditors = $ckeditorRep->findByPage('AboutUs');

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        $members = $memberRep->findAll();

        return $this->render('aboutUs/index.html.twig', [
            'path' => $path,
            'ckeditors' => $ckeditors,
            'image' => $imgPartner,
            'members' => $members
        ]);
    }

    #[Route(path: '/billeterie', name: 'ticketing', methods: ['GET'])]
    public function ticketing(Request $request, PartnershipRepository $partnershipRepo, SurveyRepository $surveyRepo, ResponseRepository $responseRepo, EntityManagerInterface $manager, TicketingRepository $ticketingRep, ImageTicketingRepository $imageTicketingRepository): Response
    {
        $path = [['Accueil', 'home'], ['Billeterie', 'ticketing']];
        $ticketingsPermanent = $ticketingRep->findByPermanent();
        $ticketingsLimited = $ticketingRep->findByLimited();
        $imageTicketing = $imageTicketingRepository->findAll();

        $partnership = $partnershipRepo->findAll();
        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        // get the question active of the survey
        $questionActive = $surveyRepo->findQuestionActive();

        // get response associated at the question of the survey
        $responseQuestion = $responseRepo->findResponseById($questionActive->getId());

        $userResponse = new UserResponse();
        $form = $this->createForm(UserResponseType::class, $userResponse);
        $form->handleRequest($request);

        $sub = new Subscriber();
        $formSub = $this->createForm(SubscriberType::class, $sub);
        $formSub->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                // get id of the respons by a search name for set response of the create UserResponse
                $response = $responseRepo->findIdResponseOfName($request->get("radio_response"));

                $userResponse->setResponse($response);
                $manager->persist($userResponse);
                $manager->flush();

                $this->addFlash('success', 'Réponse enregistrée, merci de votre participation !');
            } catch (\Throwable $th) {
                $this->addFlash('error', 'Une erreur imprévu est survenu, veillez recharger la puis réessayer.');
            }
        }

        return $this->render('ticketing/index.html.twig', [
            'path' => $path,
            'ticketingsPermanent' => $ticketingsPermanent,
            'ticketingsLimited' => $ticketingsLimited,
            'imageTicketing' => $imageTicketing,
            'partnership' => $partnership,
            'image' => $imgPartner,
            'question' => $questionActive,
            'response' => $responseQuestion,
            'form' => $form->createView(),
            'formSub' => $formSub->createView(),
        ]);
    }

    #[Route(path: '/billeterie/{id}', name: 'offer', methods: ['GET'])]
    public function offer(PartnershipRepository $partnershipRepo, TicketingRepository $ticketingRepo, string $id, ImageTicketingRepository $imgTicketingRepo): Response
    {
        $path = [['Accueil', 'home'], ['Billeterie', 'ticketing']];
        // get info associated at the id in the url of the ticketing
        $offer = $ticketingRepo->find($id);

        // get 3 random image from database
        $imgPartner = $partnershipRepo->imagePartner();

        // si $offer retourne quelque chose et que l'id est un numérique alors on render sinon redirect
        if (($offer != NULL) and (is_numeric($id))) {
            // get image associated at the id in the url of the ticketing
            $imgOffer = $imgTicketingRepo->findImageTicketing($id);

            return $this->render('ticketing/offer.html.twig', [
                'path' => $path,
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
    public function contact(PartnershipRepository $partnershipRepo, Request $request, EntityManagerInterface $manager, SubscriberRepository $subscriberRepo): Response
    {
        $path = [['Accueil', 'home'], ['Contact', 'contact']];

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
            'path' => $path,
            'image' => $imgPartner,
            'formContact' => $formContact->createView(),
        ]);
    }
}
