<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RequestsRepository;
use App\Entity\User;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
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
            return $this->render('dashboard/user.html.twig', [
                'userRequests' => $userRequests
            ]);
        }elseif($this->isGranted('ROLE_ADVISOR')){
            $usersRequests = $requestsRepository->findAllRequestsWithUser('ROLE_ADVISOR');
            dump($usersRequests);
            return $this->render('dashboard/advisor.html.twig', [
                'usersRequests' => $usersRequests
            ]);
        }elseif($this->isGranted('ROLE_VALIDATOR')){
            $usersRequests = $requestsRepository->findAllRequestsWithUser('ROLE_VALIDATOR');
            dump($usersRequests);
            return $this->render('dashboard/validator.html.twig', [
                'usersRequests' => $usersRequests
            ]);
        }
    }
}
