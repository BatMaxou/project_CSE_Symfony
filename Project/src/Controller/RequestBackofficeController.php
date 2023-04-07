<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Entity\Ticketing;
use App\Entity\UserResponse;
use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\TicketingRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\AdminFormType;

#[Route(path: '/post/backoffice/')]
class RequestBackofficeController extends AbstractController
{
    #[Route(path: 'admin-add', name: 'post_add_admin', methods: ['POST'])]
    public function postAddAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse

            $admin = new Admin();

            $admin->setEmail($request->get('admin')['email']);

            if ($request->get('admin')['plainPassword'] != "") {
                $admin->setPassword(
                    $adminPasswordHasher->hashPassword(
                        $admin,
                        $request->get('admin')['plainPassword']
                    )
                );
            }

            if ($request->get('admin')['roles'] == 1) {
                $admin->setRoles(
                    ["ROLE_ADMIN"]
                );
            } else {
                $admin->setRoles(
                    ["ROLE_SUPER_ADMIN"]
                );
            }

            $adminRepository->save($admin, true);

            return new Response('L\'ajout à bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'admin-edit', name: 'post_edit_admin', methods: ['POST'])]
    public function postEditAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin")['id'];

            $admin = $adminRepository->find($id);

            $admin->setEmail($request->get('admin')['email']);

            if ($request->get('admin')['plainPassword'] != "") {
                $admin->setPassword(
                    $adminPasswordHasher->hashPassword(
                        $admin,
                        $request->get('admin')['plainPassword']
                    )
                );
            }

            if ($request->get('admin')['roles'] == 1) {
                $admin->setRoles(
                    ["ROLE_ADMIN"]
                );
            } else {
                $admin->setRoles(
                    ["ROLE_SUPER_ADMIN"]
                );
            }

            $adminRepository->save($admin, true);

            return new Response('La modification a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'admin-delete', name: 'post_delete_admin', methods: ['POST'])]
    public function postDeleteAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin")['id'];

            $admin = $adminRepository->find($id);

            if (!$admin) {
                throw $this->createNotFoundException(
                    "Pas d'admin trouvé pour l'id : " . $id
                );
            }

            $adminRepository->remove($admin, true);

            return new Response('La suppression a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'ticketing-add', name: 'post_add_ticketing', methods: ['POST'])]
    public function postAddTicketing(TicketingRepository $ticketingRepository, Request $request): Response
    {
        try {

            $ticketing = new Ticketing();

            $ticketingRepository->save($ticketing, true);

            return new Response('L\'ajout à bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'ticketing-edit', name: 'post_edit_ticketing', methods: ['POST'])]
    public function postEditTicketing(TicketingRepository $ticketingRepository, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("ticketing")['id'];

            $ticketing = $ticketingRepository->find($id);

            if (!$ticketing) {
                throw $this->createNotFoundException(
                    "Pas d'admin trouvé pour l'id : " . $id
                );
            }

            $ticketingRepository->save($ticketing, true);

            return new Response('La modification a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'ticketing-delete', name: 'post_delete_ticketing', methods: ['POST'])]
    public function postDeleteTicketing(TicketingRepository $ticketingRepository, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin")['id'];

            $ticketing = $ticketingRepository->find($id);

            if (!$ticketing) {
                throw $this->createNotFoundException(
                    "Pas d'admin trouvé pour l'id : " . $id
                );
            }

            $ticketingRepository->remove($ticketing, true);

            return new Response('La suppression a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }
}