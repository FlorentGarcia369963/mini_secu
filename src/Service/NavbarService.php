<?php

namespace App\Service;

use Symfony\Bundle\SecurityBundle\Security;

class NavbarService
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function getNavItems() : array
    {
        $user = $this->security->getUser();

        $navbarItems = [
            ['route' => 'app_dashboard', 'label' => 'Tableau de bord', 'path' => '/tableau-de-bord'],
            ['route' => 'app_request', 'label' => 'Nouvelle démarche', 'path' => '/nouvelle-demarche'],
        ];

        if ($user) {
            $navbarItems[]= ['route' => 'app_logout', 'label' => 'Se déconnecter', 'path' => '/deconnexion'];
            
        }else{
            $navbarItems[]= ['route' => 'app_login', 'label' => 'Se connecter', 'path' => '/connexion'];
            $navbarItems[]= ['route' => 'app_registration', 'label' => 'S\'inscrire', 'path' => '/inscription'];
        }
        return $navbarItems;
    }
}
