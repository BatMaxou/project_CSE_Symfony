<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Entity\UserResponse;
use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\AdminFormType;

class RequestBackofficeController extends AbstractController
{
    #[Route(path: '/post/backoffice/adminGestion', name: 'post-admin', methods: ['POST'])]
    public function postAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        // try {
        // get id of the respons by a search name for set response of the create UserResponse
        $id = $request->get("admin_form")['id'];

        $admin = $adminRepository->find($id);

        $updateAdmin = $admin;
        $updateAdmin->setEmail($request->get('admin_form')['email']);

        if ($request->get('admin_form')['plainPassword'] != "") {
            $admin->setPassword(
                $adminPasswordHasher->hashPassword(
                    $admin,
                    $request->get('admin_form')['plainPassword']
                )
            );
        }

        if ($request->get('admin_form')['roles'] == 1) {
            $updateAdmin->setRoles(
                ["ROLE_ADMIN"]
            );
        } else {
            $updateAdmin->setRoles(
                ["ROLE_SUPER_ADMIN"]
            );
        }

        $adminRepository->save($admin, true);

        return new Response('Réponse enregistrée, merci de votre participation !', 200);
        // } catch (\Throwable $th) {
        //     return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        // }
    }
}
