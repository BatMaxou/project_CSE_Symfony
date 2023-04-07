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
        'Messages' => 'backoffice_contact',
        'Comptes' => 'backoffice_account',
        'Retour au site' => 'home',
        'Déconnexion' => 'app_logout'
    );

    private array $requestPaths = array(
        'ajout_reponse_sondage' => 'post_survey',
        'ajout_abonnement_newsletter' => 'post_newsletter',
        'modif_textes' => 'post_texts',
        'modif_partenariat' => 'post-partnership',
        'ajout_admin' => 'post_add_admin',
        'modif_admin' => 'post_edit_admin',
        'supp_admin' => 'post_delete_admin',
        'ajout_billeterie' => 'post_add_ticketing',
        'modif_billeterie' => 'post_edit_ticketing',
        'supp_billeterie' => 'post_delete_ticketing',
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