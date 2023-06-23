<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\Contact;
use App\Entity\Subscriber;
use App\Service\Validator;
use App\Entity\UserResponse;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\SurveyRepository;
use App\Repository\ContactRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/post/')]
class RequestController extends AbstractController
{
    #[Route(path: 'newsletter', name: 'post-newsletter', methods: ['POST'])]
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
                        ->from(new Address($_ENV['APP_EMAIL'], 'CSE Saint-Vincent'))
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

    #[Route(path: 'survey', name: 'post-survey', methods: ['POST'])]
    public function postSurvey(SurveyRepository $surveyRep, ResponseRepository $respRep, UserResponseRepository $userRespRep, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $response = $respRep->findById($request->get('client_survey')['radio_response']);

            // récupérer les infos du survey (car l'objet survey n'est pas encore créé)
            if (
                isset($response) &&
                ($survey = $surveyRep->findById($response->getSurvey()->getId())) &&
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
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }


    #[Route(path: 'contact', name: 'post-contact', methods: ['POST'])]
    public function postContact(MailerInterface $mailer, SubscriberRepository $subscriberRepo, Request $request, Validator $validate, ContactRepository $contact): Response
    {
        try {
            if (!empty($request->get('contact')['consent']) && $request->get('contact')['consent'] === "1") {
                if (!empty($request->get('newsletterConsentFormContact')) && $request->get('newsletterConsentFormContact') === 'on') {
                    if ($validate->checkInputEmail($request->get('contact')['email'])) {
                        if ($subscriberRepo->countByMail($request->get('contact')['email']) === 0) {
                            $sub = new Subscriber();
                            $sub->setEmail($request->get('contact')['email']);
                            $sub->setConsent(true);
                            $subscriberRepo->save($sub, true);

                            $email = (new Email())
                                ->from(new Address($_ENV['APP_EMAIL'], 'CSE Saint-Vincent'))
                                ->to($request->get('contact')['email'])
                                ->subject('Abonnement à la newsletter')
                                ->html(
                                    '<p>Merci de vous être abonner à la newsletter du CSE de Saint-Vincent.</p>' .
                                        '<p>Vous recevrez par mail chaque nouvelle offre lors de leur publication sur le site.</p>' .
                                        '<p>Pour vous désabonner, cliquez <a href="#">ici</a>.</p>'
                                );

                            $mailer->send($email);
                        }
                    } else {
                        return new Response('L\'adresse mail saisie n\'est pas conforme.', 400);
                    }
                }

                $cont = new Contact();

                $name = $validate->transformInputString($request->get('contact')['name']);
                $firstname = $validate->transformInputString($request->get('contact')['firstname']);
                $subject = $validate->transformInputString($request->get('contact')['subject']);
                $message = $validate->transformInputString($request->get('contact')['message']);

                if ($validate->checkInputEmail($request->get('contact')['email']) && $validate->checkinputString($firstname) && $validate->checkinputString($name) && $validate->checkinputString($subject) && $validate->checkinputString($message)) {

                    $cont->setName($name);
                    $cont->setFirstname($firstname);
                    $cont->setEmail($request->get('contact')['email']);
                    $cont->setSubject($subject);
                    $cont->setConsent($request->get('contact')['consent']);
                    $cont->setMessage($message);

                    $contact->save($cont, true);

                    // mailer
                    $email = (new Email())
                        ->from(new Address($_ENV['APP_EMAIL'], $request->get('contact')['email']))
                        ->to($_ENV['APP_EMAIL'])
                        ->subject($subject)
                        ->text($message);

                    $mailer->send($email);
                } else {
                    return new Response('Un des champ est mal renseigné.', 400);
                }

                return new Response('Votre message a bien été envoyé !', 200);
            } else {
                return new Response('Vous devez acceptez les conditions pour pouvoir envoyer un message.', 400);
            }
        } catch (\Throwable $th) {
            return new Response('Un problème innatendu est survenu, rechargez la page puis renvoyez votre message.', 400);
        }
    }
}
