<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Entity\UserResponse;
use App\Entity\Response as ResponseSurvey;

use App\Repository\SurveyRepository;
use App\Repository\ResponseRepository;
use App\Repository\PartnershipRepository;

use App\Form\UserResponseType\UserResponseType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET', 'POST'])]
    public function home(Request $request, PartnershipRepository $partnerRepo, SurveyRepository $surveyRepo, ResponseRepository $responseRepo, EntityManagerInterface $manager): Response
    {
        $currentNav = ['Accueil'];
        // get 3 random image from database
        $imgPartner = $partnerRepo->imagePartner();
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

        return $this->render('homePage/index.html.twig', [
            'currentNav' => $currentNav,
            'image' => $imgPartner,
            'question' => $questionActive,
            'response' => $responseQuestion,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/partenariat', name: 'partnership')]
    public function partnership(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/a_propos', name: 'aboutUs')]
    public function about(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/billeterie', name: 'ticketing')]
    public function ticketing(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('base.html.twig');
    }
}
