<?php

namespace App\Controller;

use App\Repository\CkeditorRepository;
use App\Service\StaticPathList;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(StaticPathList $staticPathList, AuthenticationUtils $authenticationUtils, CkeditorRepository $ckeditorRep): Response
    {
        $paths = [$staticPathList->getClientPathByName('Accueil'), $staticPathList->getAdminPathByName('Connexion')];

        $ckeditors = $ckeditorRep->findByPage('Client');

        $email = null;
        $phone = null;
        $place = null;

        foreach ($ckeditors as $ckeditor) {
            if ($ckeditor->getZone() === "email") {
                $email = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "phone") {
                $phone = $ckeditor->getContent();
            }
            if ($ckeditor->getZone() === "place") {
                $place = $ckeditor->getContent();
            }
        }

        $sideCkeditors = array('email' => $email, 'phone' => $phone, 'place' => $place);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'paths' => $paths,
            'sideCkeditors' => $sideCkeditors,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
