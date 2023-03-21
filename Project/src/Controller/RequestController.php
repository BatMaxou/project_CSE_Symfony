<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequestController extends AbstractController
{
    #[Route(path: '/post/newsletter', name: 'post-newsletter', methods: ['POST'])]
    public function postNewsletter(SubscriberRepository $subRep, Request $request): Response
    {
        // json response
        if ($request->get('consent') !== NULL && $request->get('consent') === 'on') {
            // validator
            if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $request->get('mail'))) {
                if ($subRep->countByMail($request->get('mail')) === 0) {
                    $sub = new Subscriber();
                    $sub->setEmail($request->get('mail'));
                    $sub->setConsent(1);
                    $subRep->save($sub, true);

                    return new Response('Vous avez été abonné à la newsletter', 200);
                }
                return new Response('Ce mail est déjà abonné', 400);
            }
            return new Response('Veuillez renseigner un mail conforme', 400);
        }
        return new Response('Veuillez accepter les conditions', 400);
    }

    #[Route(path: '/post/survey', name: 'post-survey', methods: ['POST'])]
    public function postSurvey(ResponseRepository $respRep, UserResponseRepository $userRespRep, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $response = $respRep->findIdResponseOfName($request->get('radio_response'));

            $userResp = new UserResponse();
            $userResp->setResponse($response);
            $userRespRep->save($userResp, true);

            return new Response('Réponse enregistrée, merci de votre participation !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    /*
     * ajax + request
     */
    #[Route(path: '/post/partnership', name: 'post-partnership', methods: ['POST'])]
    public function postPartnership(PartnershipRepository $partnershipRepo): Response
    {
        header('Access-Control-Allow-Origin: *');

        $partner = $partnershipRepo->find($_POST['id']);

        try {

            $partner->setName($_POST['title']);
            $partner->setDescription($_POST['description']);
            $partner->setLink($_POST['link']);
            $partnershipRepo->save($partner, true);

            return new Response('Réponse enregistrée, merci de votre participation !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévu est survenu, veillez recharger la page et réessayer.', 400);
        }
    }
}