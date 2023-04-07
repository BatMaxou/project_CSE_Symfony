<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Member;
use App\Entity\Partnership;
use App\Entity\Subscriber;
use App\Entity\Ticketing;
use App\Entity\UserResponse;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\ResponseRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\TicketingRepository;
use App\Repository\UserResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route(path: '/post/backoffice/')]
class RequestBackofficeController extends AbstractController
{
    #[Route(path: 'admin-add', name: 'post-add-admin', methods: ['POST'])]
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

            return new Response('L\'ajout a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'admin-edit', name: 'post-edit-admin', methods: ['POST'])]
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

    #[Route(path: 'admin-delete', name: 'post-delete-admin', methods: ['POST'])]
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
    #[Route(path: 'ticketing-add', name: 'post-add-ticketing', methods: ['POST'])]
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

    #[Route(path: 'ticketing-edit', name: 'post-edit-ticketing', methods: ['POST'])]
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

    #[Route(path: 'ticketing-delete', name: 'post-delete-ticketing', methods: ['POST'])]
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

    #[Route(path: '/post/edit-partnership', name: 'post-edit-partnership', methods: ['POST'])]
    public function editPartnership(PartnershipRepository $partnershipRepo, Request $request): Response
    {
        try {
            // recupérer le membre concerné
            $partner = $partnershipRepo->find($request->get('partnership')['id']);

            $partner->setName($request->get('partnership')['name']);
            $partner->setDescription($request->get('partnership')['description']);
            $partner->setLink($request->get('partnership')['link']);

            $partnershipRepo->save($partner, true);

            // si une image est précisée
            if (isset($request->files->get('partnership')['image'])) {
                // supprimer l'ancienne image s'il y a
                if ($partner->getImage() !== null) {
                    unlink($this->getParameter('kernel.project_dir') . '/public/imagesTest/' . $partner->getImage());
                }

                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/imagesTest';
                $image = $request->files->get('partnership')['image'];

                // slug de l'image
                $partner->setImage($partner->getId() . '-' . $partner->getName() . '.' . $image->guessExtension());
                // deplacer l'image dans le fichier 
                $image->move($destination, $partner->getImage());

                $partnershipRepo->save($partner, true);
            }

            return new Response('La modification du partenaire a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/add-partnership', name: 'post-add-partnership', methods: ['POST'])]
    public function addPartnership(PartnershipRepository $partnershipRepo, Request $request): Response
    {
        try {
            $partner = new Partnership();

            $partner->setName($request->get('partnership')['name']);
            $partner->setDescription($request->get('partnership')['description']);
            $partner->setLink($request->get('partnership')['link']);

            $partnershipRepo->save($partner, true);

            // definition du nom de l'image 
            if (isset($request->files->get('partnership')['image'])) {
                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/imagesTest';
                $image = $request->files->get('partnership')['image'];

                // slug de l'image
                $partner->setImage($partner->getId() . '-' . $partner->getName() . '.' . $image->guessExtension());

                // deplacer l'image dans le fichier 
                $image->move($destination, $partner->getImage());

                $partnershipRepo->save($partner, true);
            }

            return new Response('L\'ajout du partenaire a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/delete-partnership', name: 'post-delete-partnership', methods: ['POST'])]
    public function deletePartnership(PartnershipRepository $partnershipRepo, Request $request): Response
    {
        try {
            // recupérer le partenaire concerné
            $partner = $partnershipRepo->find($request->get('partnership')['id']);
            // supprimer l'image associé s'il y en a une
            if ($partner->getImage() !== null) {
                unlink($this->getParameter('kernel.project_dir') . '/public/imagesTest/' . $partner->getImage());
            }

            $partnershipRepo->remove($partner, true);

            return new Response('La suppression du partenaire a bien été effectuée !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }
}