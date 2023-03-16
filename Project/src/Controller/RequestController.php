<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequestController extends AbstractController
{
    #[Route(path: '/post', name: 'post')]
    public function post(
        SubscriberRepository $subRep,
        ResponseRepository $respRep,
        UserResponseRepository $userRespRep
    ): Response {
        header('Access-Control-Allow-Origin: *');

        if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'true') {
            if (isset($_POST['consent']) && $_POST['consent'] === 'true') {
                if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $_POST['mail'])) {
                    if ($subRep->countByMail($_POST['mail']) === 0) {
                        $sub = new Subscriber();
                        $sub->setEmailSubscriber($_POST['mail']);
                        $sub->setConsentSubscriber(1);
                        $subRep->save($sub, true);

                        return new Response('Vous avez été abonné à la newsletter', 200);
                    }
                    return new Response('Ce mail est déjà abonné', 400);
                }
                return new Response('Veuillez renseigner un mail conforme', 400);
            }
            return new Response('Veuillez accepter les conditions', 400);
        }

        if (isset($_POST['survey']) && $_POST['survey'] === 'true') {
            try {
                // get id of the respons by a search name for set response of the create UserResponse
                $response = $respRep->findIdResponseOfName($_POST['response']);

                $userResp = new UserResponse();
                $userResp->setResponse($response);
                $userRespRep->save($userResp, true);

                return new Response('Réponse enregistrée, merci de votre participation !', 200);
            } catch (\Throwable $th) {
                return new Response('Une erreur imprévu est survenu, veillez recharger la page et réessayer.', 400);
            }
        }
    }
}
