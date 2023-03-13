<?php

namespace App\Controller;

use Exception;
use App\Entity\Survey;
use App\Entity\Subscriber;
use App\Entity\UserResponse;

use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\PartnershipRepository;

use App\Entity\Response as ResponseSurvey;

use App\Form\UserResponseType\SubscriberType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Form\UserResponseType\UserResponseType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET', 'POST'])]
    public function home(Request $request, PartnershipRepository $partnerRepo, SurveyRepository $surveyRepo, ResponseRepository $responseRepo, EntityManagerInterface $manager, TicketingRepository $ticketingRep, CkeditorRepository $ckeditorRep): Response
    {
        $path = [['Accueil', 'home']];
        $ckeditor = $ckeditorRep->findByPage('HomePage');
        $ticketing = $ticketingRep->findAll();

        // get 3 random image from database
        $imgPartner = $partnerRepo->imagePartner();
        // get the question active of the survey
        $questionActive = $surveyRepo->findQuestionActive();
        // get response associated at the question of the survey
        $responseQuestion = $responseRepo->findResponseById($questionActive->getIdSurvey());

        $userResponse = new UserResponse();
        $form = $this->createForm(UserResponseType::class, $userResponse);
        $form->handleRequest($request);

        $footerSub = new Subscriber();
        $formSub = $this->createForm(SubscriberType::class, $footerSub);
        $formSub->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                // get id of the respons by a search name for set response of the create UserResponse
                $response = $responseRepo->findIdResponseOfName($request->get("radio_response"));

                $userResponse->setResponse($response);
                $manager->persist($userResponse);
                $manager->flush();

                $this->addFlash('success', 'Réponse enregistrée, merci de votre participation !');
            } catch (Exception) {
                $this->addFlash('error', 'Une erreur imprévu est survenu, veillez recharger la puis réessayer.');
            }
        }

        return $this->render('homePage/index.html.twig', [
            'path' => $path,
            'ckeditor' => $ckeditor,
            'ticketing' => $ticketing,
            'image' => $imgPartner,
            'question' => $questionActive,
            'response' => $responseQuestion,
            'form' => $form->createView(),
            'formSub' => $formSub->createView(),
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership')]
    public function partnership(PartnershipRepository $partnershipRepo, Request $request, SurveyRepository $surveyRepo, ResponseRepository $responseRepo, EntityManagerInterface $manager): Response
    {
        $path = [['Accueil', 'home'], ['Partenariat', 'partnership']];
        $partnership = $partnershipRepo->findAll();

        $imgPartner = $partnershipRepo->imagePartner();
        // get the question active of the survey
        $questionActive = $surveyRepo->findQuestionActive();
        // get response associated at the question of the survey
        $responseQuestion = $responseRepo->findResponseById($questionActive->getIdSurvey());

        $userResponse = new UserResponse();
        $form = $this->createForm(UserResponseType::class, $userResponse);
        $form->handleRequest($request);

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

        return $this->render('partnership/partnership.html.twig', [
            'path' => $path,
            'partnership' => $partnership,
            'image' => $imgPartner,
            'question' => $questionActive,
            'response' => $responseQuestion,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/a_propos', name: 'aboutUs')]
    public function about(): Response
    {
        $path = [['Accueil', 'home'], ['A propos de nous', 'aboutUs']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/billeterie', name: 'ticketing')]
    public function ticketing(): Response
    {
        $path = [['Accueil', 'home'], ['Billeterie', 'ticketing']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }

    #[Route(path: '/contact', name: 'contact')]
    public function contact(): Response
    {
        $path = [['Accueil', 'home'], ['Contact', 'contact']];

        return $this->render('base.html.twig', [
            'path' => $path,
        ]);
    }
}
