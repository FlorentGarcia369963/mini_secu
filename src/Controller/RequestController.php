<?php

namespace App\Controller;

use App\Entity\Requests;
use App\Form\RequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RequestController extends AbstractController
{
    #[Route('/nouvelle-demarche', name: 'app_request')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userRequest = new Requests;
        $user = $this->getUser();
        $form = $this->createForm(RequestFormType::class, $userRequest);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des fichiers
            $proofFile = $form->get('proof')->getData();
            $prescriptionFile = $form->get('prescription')->getData();

            //Nommage et enregistrement des fichiers, enregistrement du chemin dans la requête à entrer dans la bdd
            if($proofFile){
                $proofFileName = uniqid().'.'.$proofFile->guessExtension();
                $proofFile->move($this->getParameter('upload_directory_proof'), $proofFileName);
                $userRequest->setProof("uploads/proof/{$proofFileName}");
            }else{
                throw new \Exception('Veuillez joindre une facture acquittée.');
            }
            if($prescriptionFile){
                $prescriptionFileName = uniqid().'.'.$prescriptionFile->guessExtension();
                $prescriptionFile->move($this->getParameter('upload_directory_prescription'), $prescriptionFileName);
                $userRequest->setPrescription("uploads/prescription/{$prescriptionFileName}");

            }

            $userRequest->setStatus('recieved');
            $userRequest->setUserRequest($user);

            $entityManager->persist($userRequest);
            $entityManager->flush();

            $this->addFlash('success', 'Votre demande a été soumise avec succès !');
            return $this->redirectToRoute('app_dashboard');
        }


        return $this->render('request/index.html.twig', [
            'request_form' => $form->createView(),
        ]);
    }

    #[Route('/handle-advisor-request-action')]
    public function handleAdvisorRequestAction(Request $httpRequest, EntityManagerInterface $entityManager): Response
    {
        // Récupération du rôle de l'utilisateur
        $userRole = $this->getUser()->getRoles();
        // Récupération des actions, de l'id de la requête
        $action = $httpRequest->request->get('action');
        $requestId = $httpRequest->request->get('request_id');
        // Récupération de la requête
        $requestToProcess = $entityManager->getRepository(\App\Entity\Requests::class)->find($requestId);
        
        if (!$requestToProcess) {
            $this->addFlash('error', 'Demande introuvable.');
            return $this->redirectToRoute('dashboard');
        }
        // Récupération des liens vers les images associées à la requête
        $proofFileLink = $requestToProcess->getProof();
        $prescriptionFileLink = $requestToProcess->getPrescription();
        // Découpage des liens en vue de n'utiliser que le nom des fichiers
        $proofFileChunkLink = explode('/', $proofFileLink);
        $prescriptionFileChunkLink = explode('/', $prescriptionFileLink);

        switch ($action) {
            case 'accept':
                if(!in_array('ROLE_VALIDATOR', $userRole)){
                    throw new Exception('Action non autorisée par l\'utilisateur');
                }
                $requestToProcess->setStatus('accepted');
                $entityManager->flush();
                // dd($requestToProcess);
                return $this->redirectToRoute('app_dashboard');
                break;

            case 'transfer':
                if(!in_array('ROLE_ADVISOR', $userRole)){
                    throw new Exception('Action non autorisée par l\'utilisateur');
                }
                // Changer le statut pour que ça s'affiche sur le dashboard du contrôleur
                $requestToProcess->setStatus('in_progress');
                $entityManager->flush();
                // dd($requestToProcess);
                return $this->redirectToRoute('app_dashboard');
                break;
            case 'reject':
                if(count($userRole) === 1){
                    throw new Exception('Action non autorisée par l\'utilisateur');
                }
                // Changer le statut pour que ça s'affiche en rouge sur le dashboard du user
                $requestToProcess->setStatus('rejected');
                $entityManager->flush();
                // dd($requestToProcess);
                return $this->redirectToRoute('app_dashboard');
                break;
            case 'delete':
                if(count($userRole) === 1){
                    throw new Exception('Action non autorisée par l\'utilisateur');
                }
                        // Suppression de la requête dans la bdd
                        $entityManager->remove($requestToProcess);
                        $entityManager->flush();
                        // Mis en forme du chemin complet vers les images
                        $proofFilePath = $this->getParameter('upload_directory_proof').'/'.end($proofFileChunkLink);
                        $prescriptionFilePath = $this->getParameter('upload_directory_prescription').'/'.end($prescriptionFileChunkLink);
                        
                        // Suppression des images
                        try{
                            if($proofFileLink && file_exists($proofFilePath)){
                                unlink($proofFilePath);
                            }
                            if ($prescriptionFileLink && file_exists($prescriptionFilePath)) {
                                unlink($prescriptionFilePath);
                            }
                        } catch (\Exception $e) {
                            $this->addFlash('error', 'Erreur lors de la suppression des fichiers : ' . $e->getMessage());
                            return $this->redirectToRoute('app_dashboard');
                        }
                        // Si succès, rafraîchissement de la page.
                        $this->addFlash('success', 'Demande et fichiers associés supprimés.');
                        return $this->redirectToRoute('app_dashboard');
                break;
            
            default:
            $this->addFlash('error', 'Action non reconnue.');
            return $this->redirectToRoute('app_dashboard');

                break;
        }
    }
}
