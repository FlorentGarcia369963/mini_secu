<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RequestsRepository;
use App\Entity\User;

class DashboardController extends AbstractController
{
    #[Route('/tableau-de-bord', name: 'app_dashboard')]
    public function index(RequestsRepository $requestsRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            throw new \LogicException('Accès non autorisé : l\'utilisateur doit être authentifié.');
        }
        $userRole = $user->getRoles();
        
        if($this->isGranted('ROLE_USER') && count($userRole) === 1){
            $userRequests = $user->getRequests();
            return $this->render('dashboard/index.html.twig', [
                'userRequests' => $userRequests
            ]);
        }elseif($this->isGranted('ROLE_ADVISOR')){
            $userRequests = $requestsRepository->findAllRequestsWithUser('ROLE_ADVISOR');
            return $this->render('dashboard/index.html.twig', [
                'userRequests' => $userRequests
            ]);
        }elseif($this->isGranted('ROLE_VALIDATOR')){
            $userRequests = $requestsRepository->findAllRequestsWithUser('ROLE_VALIDATOR');
            return $this->render('dashboard/index.html.twig', [
                'userRequests' => $userRequests
            ]);
        }
    }
}
