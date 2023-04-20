<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Subscriber;
use App\Service\Validator;
use App\Entity\UserResponse;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\SurveyRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequestController extends AbstractController
{
    #[Route(path: '/post/newsletter', name: 'post_newsletter', methods: ['POST'])]
    public function postNewsletter(MailerInterface $mailer, SubscriberRepository $subRep, Request $request, Validator $validate): Response
    {
        if (isset($request->get('subscriber')['consent']) && $request->get('subscriber')['consent'] === "1") {
            if ($validate->checkInputEmail($request->get('subscriber')['email'])) {
                if ($subRep->countByMail($request->get('subscriber')['email']) === 0) {
                    $sub = new Subscriber();
                    $sub->setEmail($request->get('subscriber')['email']);
                    $sub->setConsent(true);
                    $subRep->save($sub, true);

                    // mailer
                    $email = (new Email())
                        ->from(new Address('maximebatista.lycee@gmail.com', 'CSE Saint-Vincent'))
                        ->to($sub->getEmail())
                        ->subject('Abonnement à la newsletter')
                        ->html(
                            '<p>Merci de vous être abonner à la newsletter du CSE de Saint-Vincent.</p>' .
                                '<p>Vous recevrez par mail chaque nouvelle offre lors de leur publication sur le site.</p>' .
                                '<p>Pour vous désabonner, cliquez <a href="#">ici</a>.</p>'
                        );

                    $mailer->send($email);

                    return new Response('Vous avez été abonné à la newsletter', 200);
                }
                return new Response('Ce mail est déjà abonné', 400);
            }
            return new Response('Veuillez renseigner un mail conforme', 400);
        }
        return new Response('Veuillez accepter les conditions', 400);
    }

    #[Route(path: '/post/survey', name: 'post_survey', methods: ['POST'])]
    public function postSurvey(SurveyRepository $surveyRep, ResponseRepository $respRep, UserResponseRepository $userRespRep, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $response = $respRep->findResponseById($request->get('client_survey')['radio_response']);

            // récupérer les infos du survey (car l'objet survey n'est pas encore créé)
            if (
                isset($response) &&
                ($survey = $surveyRep->findSurveyById($response->getSurvey()->getId())) &&
                $survey->isIsActive() &&
                !isset($_COOKIE['survey-' . $survey->getId()])
            ) {
                $survey->setNbVote($survey->getNbVote() + 1);
                $response->setSurvey($survey);
                $response->setNbVote($response->getNbVote() + 1);

                $userResp = new UserResponse();
                $userResp->setResponse($response);

                $surveyRep->save($survey);
                $respRep->save($response);
                $userRespRep->save($userResp, true);

                $interval = DateInterval::createFromDateString('7 day');

                $cookie = Cookie::create('survey-' . $survey->getId())
                    ->withValue(true)
                    ->withExpires(date_add(new DateTime(), $interval))
                    ->withSecure(true);

                $httpResponse = new Response('Réponse enregistrée, merci de votre participation !', 200);
                $httpResponse->headers->setCookie($cookie);

                return $httpResponse;
            } else {
                return new Response('Vous avez déjà participé à ce sondage ou celui-ci n\'est plus disponible.', 400);
            }

            return new Response('Cette réponse ne correspond pas à ce formulaire', 400);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/texts', name: 'post_texts', methods: ['POST'])]
    public function postTexts(CkeditorRepository $rep, Request $request): Response
    {
        try {
            $texts = [
                'homepage' => $rep->findByZone('HomePage', 'zone'),
                'email' => $rep->findByZone('AboutUs', 'email'),
                'actions' => $rep->findByZone('AboutUs', 'actions'),
                'rules' => $rep->findByZone('AboutUs', 'rules'),
            ];

            $rep->save($texts['homepage']->setContent($request->get('texts')['homepage']), true);
            $rep->save($texts['email']->setContent($request->get('texts')['email']), true);
            $rep->save($texts['actions']->setContent($request->get('texts')['actions']), true);
            $rep->save($texts['rules']->setContent($request->get('texts')['rules']), true);

            return new Response('Réponse enregistrée, merci de votre participation !', 200);
        } catch (\Throwable $th) {
            return new Response($th, 400);
        }
    }
}
