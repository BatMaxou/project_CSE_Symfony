<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Member;
use App\Entity\Subscriber;
use App\Form\AdminFormType;
use App\Entity\UserResponse;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RequestBackofficeController extends AbstractController
{
    #[Route(path: '/post/backoffice/admin-add', name: 'post-add-admin', methods: ['POST'])]
    public function postAddAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse

            $admin = new Admin();

            $admin->setEmail($request->get('admin_form')['email']);

            if ($request->get('admin_form')['plainPassword'] != "") {
                $admin->setPassword(
                    $adminPasswordHasher->hashPassword(
                        $admin,
                        $request->get('admin_form')['plainPassword']
                    )
                );
            }

            if ($request->get('admin_form')['roles'] == 1) {
                $admin->setRoles(
                    ["ROLE_ADMIN"]
                );
            } else {
                $admin->setRoles(
                    ["ROLE_SUPER_ADMIN"]
                );
            }

            $adminRepository->save($admin, true);

            return new Response('L\'ajout a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/admin-edit', name: 'post-edit-admin', methods: ['POST'])]
    public function postEditAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin_form")['id'];

            $admin = $adminRepository->find($id);

            $admin->setEmail($request->get('admin_form')['email']);

            if ($request->get('admin_form')['plainPassword'] != "") {
                $admin->setPassword(
                    $adminPasswordHasher->hashPassword(
                        $admin,
                        $request->get('admin_form')['plainPassword']
                    )
                );
            }

            if ($request->get('admin_form')['roles'] == 1) {
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

    #[Route(path: '/post/backoffice/admin-delete', name: 'post-delete-admin', methods: ['POST'])]
    public function postDeleteAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin_form")['id'];

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

    #[Route(path: '/post/backoffice/member-add', name: 'post-add-member', methods: ['POST'])]
    public function postAddMember(MemberRepository $memberRepository, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse

            $member = new Member();

            $member->setFirstName($request->get('member')['firstName']);
            $member->setLastName($request->get('member')['lastName']);
            $member->setFunction($request->get('member')['function']);

            $memberRepository->save($member, true);

            // definition du nom de l'image
            if (isset($request->files->get('member')['profil'])) {
                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/imagesTest';
                $image = $request->files->get('member')['profil'];

                // slug de l'image
                $member->setProfil($member->getId() . '-' . $member->getFirstName() . '-' . $member->getLastName() . '.' . $image->guessExtension());

                // deplacer l'image dans le fichier 
                $image->move($destination, $member->getProfil());

                $memberRepository->save($member, true);
            }

            return new Response('L\'ajout a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/member-edit', name: 'post-edit-member', methods: ['POST'])]
    public function postEditMember(MemberRepository $memberRepository, Request $request): Response
    {
        try {
            // recupérer le membre concerné
            $member = $memberRepository->findById($request->get('member')['id']);

            $member->setFirstName($request->get('member')['firstName']);
            $member->setLastName($request->get('member')['lastName']);
            $member->setFunction($request->get('member')['function']);

            // si une image est précisée
            if (isset($request->files->get('member')['profil'])) {

                // supprimer l'ancienne image s'il y a
                if ($member->getProfil() !== null) {
                    unlink($this->getParameter('kernel.project_dir') . '/public/imagesTest/' . $member->getProfil());
                }

                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/imagesTest';
                $image = $request->files->get('member')['profil'];

                // slug de l'image
                $member->setProfil($member->getId() . '-' . $member->getFirstName() . '-' . $member->getLastName() . '.' . $image->guessExtension());

                // deplacer l'image dans le fichier 
                $image->move($destination, $member->getProfil());
            }
            $memberRepository->save($member, true);

            return new Response('La modification a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/member-delete', name: 'post-delete-member', methods: ['POST'])]
    public function postDeleteMember(MemberRepository $memberRepository, Request $request): Response
    {
        try {
            // recupérer le membre concerné
            $member = $memberRepository->findById($request->get('member')['id']);

            // supprimer l'image associé s'il y a
            if ($member->getProfil() !== null) {
                unlink($this->getParameter('kernel.project_dir') . '/public/imagesTest/' . $member->getProfil());
            }

            $memberRepository->remove($member, true);

            return new Response('La suppression a bien été effectuée !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    /*

    #[Route(path: '/post/backoffice/admin-edit', name: 'post-edit-admin', methods: ['POST'])]
    public function postEditAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin_form")['id'];

            $admin = $adminRepository->find($id);

            $admin->setEmail($request->get('admin_form')['email']);

            if ($request->get('admin_form')['plainPassword'] != "") {
                $admin->setPassword(
                    $adminPasswordHasher->hashPassword(
                        $admin,
                        $request->get('admin_form')['plainPassword']
                    )
                );
            }

            if ($request->get('admin_form')['roles'] == 1) {
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

    #[Route(path: '/post/backoffice/admin-delete', name: 'post-delete-admin', methods: ['POST'])]
    public function postDeleteAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin_form")['id'];

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

    */
}
