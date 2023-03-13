<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RequestController extends AbstractController
{
    #[Route(path: '/post', name: 'post')]
    public function post(SubscriberRepository $subRep): Response
    {
        header('Access-Control-Allow-Origin: *');

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
}
