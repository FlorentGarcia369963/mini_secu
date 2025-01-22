<?php

namespace App\Twig;

use App\Service\NavbarService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavbarExtension extends AbstractExtension{
    private $navbarService;

    public function __construct(NavbarService $navbarService)
    {
        $this->navbarService= $navbarService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_nav_items', [$this, 'getNavItems']),
        ];
    }

    public function getNavItems(): array
    {
        return $this->navbarService->getNavItems();
    }

}