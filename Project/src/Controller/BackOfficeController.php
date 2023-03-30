<?php

namespace App\Controller;

use App\Entity\Partnership;
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

class BackOfficeController extends AbstractController
{
    public function formEditPartnership(): Response
    {
        $form = $this->createForm(PartnershipType::class, null, [
            'action' => '/post/editPartnership',
            'method' => 'POST'
        ]);

        return $this->render('backoffice/partnership/partnership.html.twig', [
            'formPartnership' => $form,
        ]);
    }

    #[Route(path: '/admin', name: 'backoffice')]
    public function login(): Response
    {
        $path = [['Tableau de bord', 'backoffice']];

        return $this->render('backoffice/index.html.twig', [
            'path' => $path
        ]);
    }

    #[Route(path: '/admin/partenariat', name: 'backoffice_partnership')]
    public function partnership(PartnershipRepository $partnershipRepo, Request $request, EntityManagerInterface $manager): Response
    {
        $path = [['Infos', 'backoffice'], ['Partenariat', 'backoffice_partnership']];

        $partnerships = $partnershipRepo->findAll();

        $form = $this->createForm(PartnershipType::class, null, [
            'action' => '/post/edit-partnership',
            'method' => 'POST',
        ]);

        $forms = array();

        for ($i = 0; $i < count($partnerships); $i++) {
            $forms[] = $form->createView();
        }

        return $this->render('backoffice/partnership/partnership.html.twig', [
            'path' => $path,
            'partnerships' => $partnerships,
            'formPartnership' => $forms,
        ]);
    }

    #[Route(path: '/admin/sondage', name: 'backoffice_sondage')]
    public function survey(SurveyRepository $surveyRepo): Response
    {
        $path = [['Infos', 'backoffice'], ['Sondage', 'backoffice_sondage']];

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
}
