<?php

namespace App\Service;

class StaticPathList
{
    private array $clientPaths = array(
        'Accueil' => 'home',
        'Partenariats' => 'partnership',
        'A propos de nous' => 'about_us',
        'Billeterie' => 'ticketing',
        'Contact' => 'contact',
    );

    private array $adminPaths = array(
        'Connexion' => 'app_login',
        'Tableau de bord' => 'backoffice_dashboard',
        'Textes enrichis' => 'backoffice_text',
        'Membres' => 'backoffice_member',
        'Partenariats' => 'backoffice_partnership',
        'Billeterie' => 'backoffice_ticketing',
        'Sondage' => 'backoffice_survey',
        'Messages' => 'backoffice_messages',
        'Comptes' => 'backoffice_account',
        'Retour au site' => 'home',
        'Déconnexion' => 'app_logout'
    );

    private array $requestPaths = array(
        'ajout_reponse_sondage' => 'post-survey',
        'ajout_sondage' => 'post-add-survey',
        'modif_sondage' => 'post-edit-survey',
        'supp_sondage' => 'post-delete-survey',
        'ajout_abonnement_newsletter' => 'post-newsletter',
        'modif_textes' => 'post_texts',
        'ajout_membre' => 'post-add-member',
        'modif_membre' => 'post-edit-member',
        'sup_membre' => 'post-delete-member',
        'modif_partenariat' => 'post-edit-partnership',
        'ajout_partenariat' => 'post-add-partnership',
        'supprimer_partenariat' => 'post-delete-partnership',
        'ajout_admin' => 'post-add-admin',
        'modif_admin' => 'post-edit-admin',
        'supp_admin' => 'post-delete-admin',
        'supprimer_admin' => 'post-delete-admin',
        'ajout_billeterie' => 'post-add-ticketing',
        'modif_billeterie' => 'post-edit-ticketing',
        'supp_billeterie' => 'post-delete-ticketing',
        // utiliser pour le form contact client
        'envoi_contact' => 'post-contact',
        // utiliser pour la partie message du backoffice
        'rep_msg' => 'post-rep-msg',
        'supprimer_msg' => 'post-delete-msg',
    );

    public function getClientPathByName(string $name): array
    {
        return array($name, $this->clientPaths[$name]);
    }

    public function getAdminPathByName(string $name): array
    {
        return array($name, $this->adminPaths[$name]);
    }

    public function getRequestPathByName(string $name): ?string
    {
        return $this->requestPaths[$name];
    }
}
