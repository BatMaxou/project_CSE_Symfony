<?php

namespace App\Controller;

use App\Entity\Ckeditor;
use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Repository\CkeditorRepository;
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

    #[Route(path: '/post/backoffice/texts', name: 'post-texts', methods: ['POST'])]
    public function postTexts(CkeditorRepository $rep, Request $request): Response
    {
        try {
            $texts = [
                'homepage' => $rep->findByZone('HomePage', 'zone'),
                'email' => $rep->findByZone('AboutUs', 'email'),
                'actions' => $rep->findByZone('AboutUs', 'actions'),
                'rules' => $rep->findByZone('AboutUs', 'rules'),
            ];

            $rep->save($texts['homepage']->setContent($request->get('text')['homepage']), true);
            $rep->save($texts['email']->setContent($request->get('text')['email']), true);
            $rep->save($texts['actions']->setContent($request->get('text')['actions']), true);
            $rep->save($texts['rules']->setContent($request->get('text')['rules']), true);

            // $userRespRep->save($userResp, true);

            return new Response('Réponse enregistrée, merci de votre participation !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/edit-partnership', name: 'post-partnership', methods: ['POST'])]
    public function editPartnership(PartnershipRepository $partnershipRepo, Request $request): Response
    {
        $id = $request->get('partnership')['id'];
        $partner = $partnershipRepo->find($id);

        try {
            $partner->setName($request->get('partnership')['name']);
            $partner->setDescription($request->get('partnership')['description']);
            $partner->setLink($request->get('partnership')['link']);

            // condition pour set l'image, si l'input image est pas null ce qui veut dire qu'on a renseigné une image alors on set l'image sinon on gare l'image de base 
            if ($request->files->get('partnership')['image'] !== null) {
                $partner->setImage($request->files->get('partnership')['image']->getClientOriginalName());
                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/imagesTest';
                $image = $request->files->get('partnership')['image'];
                // get le nom original de l'image
                $file_name = $image->getClientOriginalName();
                // deplace l'image dans le fichier 
                $image->move($destination, $file_name); // move files to destination folder
            }

            $partnershipRepo->save($partner, true);

            return new Response('Les modifications on bien été enregistré !', 200);
        } catch (\Throwable $th) {
            return new Response($th, 400);
        }
    }

    #[Route(path: '/post/delete-partnership', name: 'delete-partnership', methods: ['POST'])]
    public function deletePartnership(PartnershipRepository $partnershipRepo, Request $request): Response
    {
        $id = $request->get('partnership')['id'];
        $partner = $partnershipRepo->find($id);

        try {
            $partnershipRepo->remove($partner, true);

            return new Response('La suppression du partenaire a bien été enregistré !', 200);
        } catch (\Throwable $th) {
            return new Response('Suppresion du partenaire impossible !', 400);
        }
    }
}
