<?php

namespace App\Service;

use App\Repository\AdminRepository;
use App\Repository\MemberRepository;
use App\Repository\SurveyRepository;
use App\Repository\ContactRepository;
use App\Repository\CkeditorRepository;
use App\Repository\ResponseRepository;
use App\Repository\TicketingRepository;
use App\Repository\SubscriberRepository;
use App\Repository\PartnershipRepository;
use App\Repository\UserResponseRepository;
use App\Repository\ImageTicketingRepository;

class DatafixturesBuilder
{
    private array $repositories;

    function __construct(
        AdminRepository $adminRep,
        CkeditorRepository $textsRep,
        ContactRepository $contactRep,
        ImageTicketingRepository $imgTicketingRep,
        MemberRepository $memberRep,
        PartnershipRepository $partnershipRep,
        ResponseRepository $responseRep,
        SubscriberRepository $subRep,
        SurveyRepository $surveyRep,
        TicketingRepository $ticketingRep,
        UserResponseRepository $userRespRep
    ) {
        $this->repositories['admin'] = $adminRep;
        $this->repositories['ckeditor'] = $textsRep;
        $this->repositories['contact'] = $contactRep;
        $this->repositories['imageTicketing'] = $imgTicketingRep;
        $this->repositories['member'] = $memberRep;
        $this->repositories['partnership'] = $partnershipRep;
        $this->repositories['response'] = $responseRep;
        $this->repositories['subscriber'] = $subRep;
        $this->repositories['survey'] = $surveyRep;
        $this->repositories['ticketing'] = $ticketingRep;
        $this->repositories['userResponse'] = $userRespRep;
    }

    public function build(array $yaml, $io = null): bool
    {
        try {
            // pour chaque table
            foreach ($yaml as $table => $inserts) {
                $compt = 0;
                // pour chaque INSERT
                foreach ($inserts as $columns) {
                    // exception pour les CkRditor qui sont définis à '' de base (faire un update au lileu d'un insert)
                    // sinon créer une nouvelle entité
                    if ($table === 'ckeditor') {
                        $entity = $this->repositories['ckeditor']->findByZone($columns['pageName'], $columns['zone']);
                    } else {
                        $entity = new (('App\\Entity\\') . ucfirst($table))();
                    }
                    // pour chaque colones
                    foreach ($columns as $column => $value) {
                        // gérer les datetime ou autres class basiques
                        // ou gérer les clés étrangères
                        if (isset($value['class'])) {
                            $value = new $value['class']($value['value']);
                        } elseif (isset($value['entity'])) {
                            $value = $this->repositories[$value['entity']]->findById($value['id'])[0];
                        }
                        $setter = 'set' . ucfirst($column);
                        $entity->$setter($value);
                    }
                    $this->repositories[$table]->save($entity, true);
                    $compt++;
                }
                $io->info($compt . ' row(s) inserted into : ' . ucfirst($table));
            }
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}
