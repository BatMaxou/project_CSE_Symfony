<?php

namespace App\Controller;

use DateTime;
use App\Entity\Admin;
use App\Entity\Member;
use App\Entity\Survey;
use App\Entity\Response as SurveyResponse;
use App\Entity\Ticketing;
use App\Entity\Partnership;
use App\Entity\ImageTicketing;
use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\PartnershipRepository;
use App\Repository\ImageTicketingRepository;
use App\Repository\UserResponseRepository;
use App\Service\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route(path: '/post/backoffice/')]
class RequestBackofficeController extends AbstractController
{
    #[Route(path: 'admin-add', name: 'post-add-admin', methods: ['POST'])]
    public function postAddAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request, Validator $validate): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse

            $admin = new Admin();

            if ($validate->checkInputEmail($request->get('admin')['email'])) {
                $admin->setEmail($request->get('admin')['email']);

                if (!empty($request->get('admin')['plainPassword']) && $validate->checkInputPassword($request->get('admin')['plainPassword'])) {
                    $admin->setPassword(
                        $adminPasswordHasher->hashPassword(
                            $admin,
                            $request->get('admin')['plainPassword']
                        )
                    );

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
                } else {
                    return new Response('Le mot de passe doit contenir au minimum : 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spéacial.', 400);
                }
            } else {
                return new Response('L\'adresse mail saisie n\'est pas conforme.', 400);
            }
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: 'admin-edit', name: 'post-edit-admin', methods: ['POST'])]
    public function postEditAdmin(AdminRepository $adminRepository, UserPasswordHasherInterface $adminPasswordHasher, Request $request, Validator $validate): Response
    {
        try {
            // get id of the respons by a search name for set response of the create UserResponse
            $id = $request->get("admin")['id'];

            $admin = $adminRepository->find($id);

            if ($validate->checkInputEmail($request->get('admin')['email'])) {

                $admin->setEmail($request->get('admin')['email']);

                if (!empty($request->get('admin')['plainPassword'])) {
                    if ($validate->checkInputPassword($request->get('admin')['plainPassword'])) {
                        $admin->setPassword(
                            $adminPasswordHasher->hashPassword(
                                $admin,
                                $request->get('admin')['plainPassword']
                            )
                        );
                    } else {
                        return new Response('Le mot de passe doit contenir au minimum : 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spéacial.', 400);
                    }
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
            } else {
                return new Response('L\'adresse mail saisie n\'est pas conforme.', 400);
            }
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
    public function postAddTicketing(TicketingRepository $ticketingRepository, ImageTicketingRepository $imageTicketingRepository, PartnershipRepository $partnershipRepository, Request $request): Response
    {
        try {
            $ticketing = new Ticketing();

            if ($request->get('ticketing')['type'] === "0") {
                $ticketing->setType("permanente");
                $ticketing->setNumberMinPlace(intval($request->get('ticketing')['number_min_place']));
            } else {
                $ticketing->setType("limitée");
                $ticketing->setOrderNumber(intval($request->get('ticketing')['order_number']));
            }

            $ticketing->setName($request->get('ticketing')['name']);
            $ticketing->setText($request->get('ticketing')['text']);

            $time = new DateTime($request->get('ticketing')['date_start']);
            $ticketing->setDateStart($time);

            $time = new DateTime($request->get('ticketing')['date_end']);
            $ticketing->setDateEnd($time);
            $ticketing->setDateCreate(new DateTime('NOW'));

            if ($request->get('ticketing')['partnership']) {
                $partnership = $partnershipRepository->find($request->get('ticketing')['partnership']);
                $ticketing->setPartnership($partnership);
            }

            $ticketing->setSlug(str_replace(' ', '', $request->get('ticketing')['name']));

            $ticketingRepository->save($ticketing, true);

            $image1 = new ImageTicketing();

            // path le chemin de destination pour l'image 
            $destination = $this->getParameter('kernel.project_dir') . '/public/images/ticketing';
            $image = $request->files->get('ticketing')['image1'];

            // slug de l'image
            $image1->setName($ticketing->getId() . '-' . $ticketing->getName() . '-image-1' . '.' . $image->guessExtension());
            $image1->setTicketing($ticketing);

            // deplacer l'image dans le fichier 
            $image->move($destination, $image1->getName());

            $imageTicketingRepository->save($image1, true);

            if (isset($request->files->get('ticketing')['image2'])) {
                $image2 = new ImageTicketing();

                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/images/ticketing';
                $image = $request->files->get('ticketing')['image2'];

                // slug de l'image
                $image2->setName($ticketing->getId() . '-' . $ticketing->getName() . '-image-2' . '.' . $image->guessExtension());
                $image2->setTicketing($ticketing);

                // deplacer l'image dans le fichier 
                $image->move($destination, $image2->getName());

                $imageTicketingRepository->save($image2, true);
            }

            if (isset($request->files->get('ticketing')['image3'])) {
                $image3 = new ImageTicketing();

                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/images/ticketing';
                $image = $request->files->get('ticketing')['image3'];

                // slug de l'image
                $image3->setName($ticketing->getId() . '-' . $ticketing->getName() . '-image-3' . '.' . $image->guessExtension());
                $image3->setTicketing($ticketing);

                // deplacer l'image dans le fichier 
                $image->move($destination, $image3->getName());

                $imageTicketingRepository->save($image3, true);
            }

            if (isset($request->files->get('ticketing')['image4'])) {
                $image4 = new ImageTicketing();

                // path le chemin de destination pour l'image 
                $destination = $this->getParameter('kernel.project_dir') . '/public/images/ticketing';
                $image = $request->files->get('ticketing')['image4'];

                // slug de l'image
                $image4->setName($ticketing->getId() . '-' . $ticketing->getName() . '-image-4' . '.' . $image->guessExtension());
                $image4->setTicketing($ticketing);

                // deplacer l'image dans le fichier 
                $image->move($destination, $image4->getName());

                $imageTicketingRepository->save($image4, true);
            }

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
    public function postAddMember(MemberRepository $memberRepository, Request $request, Validator $validate): Response
    {
        try {
            $member = new Member();

            if ($validate->checkinputString($request->get('member')['firstName']) && $validate->checkinputString($request->get('member')['lastName']) && $validate->checkinputString($request->get('member')['function'])) {
                $member->setFirstName($request->get('member')['firstName']);
                $member->setLastName($request->get('member')['lastName']);
                $member->setFunction($request->get('member')['function']);
                $memberRepository->save($member, true);

                // definition du nom de l'image
                if (isset($request->files->get('member')['profil'])) {
                    // path le chemin de destination pour l'image 
                    $destination = $this->getParameter('kernel.project_dir') . '/public/images/member';
                    $image = $request->files->get('member')['profil'];

                    // slug de l'image
                    $member->setProfil($member->getId() . '-' . $member->getFirstName() . '-' . $member->getLastName() . '.' . $image->guessExtension());

                    // deplacer l'image dans le fichier 
                    $image->move($destination, $member->getProfil());

                    $memberRepository->save($member, true);
                }

                return new Response('L\'ajout a bien été effectué !', 200);
            } else {
                return new Response('Les champs prénom, nom et fonction doivent contenir : des lettres minuscules, majuscules et des chiffres, avec un minimum de 2 caractères', 400);
            }
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/member-edit', name: 'post-edit-member', methods: ['POST'])]
    public function postEditMember(MemberRepository $memberRepository, Request $request, Validator $validate): Response
    {
        try {
            // recupérer le membre concerné
            $member = $memberRepository->findById($request->get('member')['id']);

            if ($validate->checkinputString($request->get('member')['firstName']) && $validate->checkinputString($request->get('member')['lastName']) && $validate->checkinputString($request->get('member')['function'])) {
                $member->setFirstName($request->get('member')['firstName']);
                $member->setLastName($request->get('member')['lastName']);
                $member->setFunction($request->get('member')['function']);

                // si une image est précisée
                if (isset($request->files->get('member')['profil'])) {

                    // supprimer l'ancienne image s'il y a
                    if ($member->getProfil() !== null) {
                        unlink($this->getParameter('kernel.project_dir') . '/public/images/member/' . $member->getProfil());
                    }

                    // path le chemin de destination pour l'image 
                    $destination = $this->getParameter('kernel.project_dir') . '/public/images/member';
                    $image = $request->files->get('member')['profil'];

                    // slug de l'image
                    $member->setProfil($member->getId() . '-' . $member->getFirstName() . '-' . $member->getLastName() . '.' . $image->guessExtension());

                    // deplacer l'image dans le fichier 
                    $image->move($destination, $member->getProfil());
                }
                $memberRepository->save($member, true);

                return new Response('La modification a bien été effectué !', 200);
            } else {
                return new Response('Les champs prénom, nom et fonction doivent contenir : des lettres minuscules, majuscules et des chiffres, avec un minimum de 2 caractères', 400);
            }
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
                unlink($this->getParameter('kernel.project_dir') . '/public/images/member/' . $member->getProfil());
            }

            $memberRepository->remove($member, true);

            return new Response('La suppression a bien été effectuée !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/edit-partnership', name: 'post-edit-partnership', methods: ['POST'])]
    public function editPartnership(PartnershipRepository $partnershipRepo, Request $request, Validator $validate): Response
    {
        try {
            // recupérer le membre concerné
            $partner = $partnershipRepo->find($request->get('partnership')['id']);

            if ($validate->checkinputString($request->get('partnership')['name']) && $validate->checkinputString($request->get('partnership')['description']) && $validate->checkinputString($request->get('partnership')['link'])) {
                $partner->setName($request->get('partnership')['name']);
                $partner->setDescription($request->get('partnership')['description']);
                $partner->setLink($request->get('partnership')['link']);

                $partnershipRepo->save($partner, true);

                // si une image est précisée
                if (isset($request->files->get('partnership')['image'])) {
                    // supprimer l'ancienne image s'il y a
                    if ($partner->getImage() !== null) {
                        unlink($this->getParameter('kernel.project_dir') . '/public/images/partnership/' . $partner->getImage());
                    }

                    // path le chemin de destination pour l'image 
                    $destination = $this->getParameter('kernel.project_dir') . '/public/images/partnership';
                    $image = $request->files->get('partnership')['image'];

                    // slug de l'image
                    $partner->setImage($partner->getId() . '-' . $partner->getName() . '.' . $image->guessExtension());
                    // deplacer l'image dans le fichier 
                    $image->move($destination, $partner->getImage());

                    $partnershipRepo->save($partner, true);
                }
                return new Response('La modification du partenaire a bien été effectué !', 200);
            } else {
                return new Response('Le champ nom, description et lien doit contenir : des lettres minuscules, majuscules et des chiffres, avec un minimum de 2 caractères', 400);
            }
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/add-partnership', name: 'post-add-partnership', methods: ['POST'])]
    public function addPartnership(PartnershipRepository $partnershipRepo, Request $request, Validator $validate): Response
    {
        try {
            $partner = new Partnership();

            if ($validate->checkinputString($request->get('partnership')['name']) && $validate->checkinputString($request->get('partnership')['description']) && $validate->checkinputString($request->get('partnership')['link'])) {
                $partner->setName($request->get('partnership')['name']);
                $partner->setDescription($request->get('partnership')['description']);
                $partner->setLink($request->get('partnership')['link']);

                $partnershipRepo->save($partner, true);

                // definition du nom de l'image 
                if (isset($request->files->get('partnership')['image'])) {
                    // path le chemin de destination pour l'image 
                    $destination = $this->getParameter('kernel.project_dir') . '/public/images/partnership';
                    $image = $request->files->get('partnership')['image'];

                    // slug de l'image
                    $partner->setImage($partner->getId() . '-' . $partner->getName() . '.' . $image->guessExtension());

                    // deplacer l'image dans le fichier 
                    $image->move($destination, $partner->getImage());

                    $partnershipRepo->save($partner, true);
                }

                return new Response('L\'ajout du partenaire a bien été effectué !', 200);
            } else {
                return new Response('Le champ nom, description et lien doit contenir uniquement des lettres minuscules ou majuscules avec un minimum de 2 caractères', 400);
            }
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
                unlink($this->getParameter('kernel.project_dir') . '/public/images/partnership/' . $partner->getImage());
            }

            $partnershipRepo->remove($partner, true);

            return new Response('La suppression a bien été effectuée !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/ajout-sondage', name: 'post-add-survey', methods: ['POST'])]
    public function addSurvey(SurveyRepository $sureveyRepo, ResponseRepository $respRepo, Request $request, Validator $validate): Response
    {
        try {

            $survey = new Survey();

            if ($validate->checkinputString($request->get('survey')['question'])) {
                $survey->setQuestion($request->get('survey')['question']);
                $survey->setDatetime(new DateTime());
                $survey->setIsActive(true);

                // desactivate the active survey
                if ($sureveyRepo->findActiveSurvey() !== null) {
                    $sureveyRepo->findActiveSurvey()->setIsActive(false);
                }

                // vérification que le sondage possède au moins 2 réponses
                if (count($request->get('survey')) - 1 >= 2) {
                    $responses = [];

                    for ($i = 1; $i < count($request->get('survey')); $i++) {
                        $response = new SurveyResponse();

                        if ($validate->checkinputString($request->get('survey')['response_' . $i])) {
                            $response->setText($request->get('survey')['response_' . $i]);
                            $response->setSurvey($survey);

                            $responses[] = $response;
                        } else {
                            return new Response('La réponse ' . $i . ' doit comporter uniquement des lettres et des chiffres avec au moins deux caractères.', 400);
                        }
                    }
                    $sureveyRepo->save($survey, true);

                    foreach ($responses as $response) {
                        $respRepo->save($response, true);
                    }

                    return new Response('L\'ajout a bien été effectué !', 200);
                } else {
                    return new Response('Un sondage doit au moins contenir 2 réponses.', 400);
                }
            } else {
                return new Response('La question doit comporter uniquement des lettres et des chiffres avec au moins deux caractères.', 400);
            }
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/modif-sondage', name: 'post-edit-survey', methods: ['POST'])]
    public function editSurvey(SurveyRepository $sureveyRepo, Request $request): Response
    {
        try {
            $survey = $sureveyRepo->findSurveyById($request->get('survey')['id']);
            $survey->setIsActive(false);

            $sureveyRepo->save($survey, true);

            return new Response('L\'archivage a bien été effectué !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }

    #[Route(path: '/post/backoffice/supp-sondage', name: 'post-delete-survey', methods: ['POST'])]
    public function deleteSurvey(SurveyRepository $sureveyRepo, ResponseRepository $respRepo, UserResponseRepository $userRespRepo, Request $request): Response
    {
        try {
            $responses = $respRepo->findResponsesBySurveyId($request->get('survey')['id']);

            foreach ($responses as $response) {
                $userResponses = $userRespRepo->findUserResponsesByResponseId($response->getId());

                foreach ($userResponses as $userResponse) {
                    $userRespRepo->remove($userResponse, true);
                }

                $respRepo->remove($response, true);
            }

            $survey = $sureveyRepo->findSurveyById($request->get('survey')['id']);
            $sureveyRepo->remove($survey, true);

            return new Response('La suppression a bien été effectuée !', 200);
        } catch (\Throwable $th) {
            return new Response('Une erreur imprévue est survenue, veuillez recharger la page et réessayer.', 400);
        }
    }
}
